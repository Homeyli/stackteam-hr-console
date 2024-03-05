<?php 


namespace App\Services;
use App\Models\BotUser;

use App\Models\Personnel;
use App\Models\Salary;
use App\Models\TimeTable;
use App\Models\Traffic;

use Hekmatinasser\Verta\Verta;

class HRCalc {

    //ew static($datetime, $timezone)

    protected $user = null;
    protected $personnel = null;
    protected $salary = [];

    public function __construct(BotUser $user)
    {
        $this->user = $user;
    }

    public static function User(BotUser $user) {
        return new static($user);
    }

    public function getPersonnel() {
        
        if(is_null($this->personnel)) {
            $this->personnel = Personnel::where('is_active',true)->where('bot_user_id',$this->user->id)->first();
        }

        return $this->personnel;
    }

    public function getPersonnelApprovedSalary(string $time=null) {
        
        if (empty($this->salary)) {

            $_salary = Salary::where('personnel_id',$this->getPersonnel()->id)->get();
            foreach($_salary as $item) {
                $this->salary[$item->year . '-' . $item->month] = $item->amount;
            }    
        }

        if (is_null($time)) {

            $verta = new Verta();
            $time = $verta->now('asia/tehran')->format('Y-m');
        }

        if (!isset($this->salary[$time])) {

            $this->salary[$time] = end($this->salary);
            $exTime = explode('-',$time);

            Salary::create([
                'personnel_id' => $this->getPersonnel()->id,
                'year' => $exTime[0],
                'month' => $exTime[1],
                'amount' => $this->salary[$time]
            ]);
        }

        return $this->salary[$time];
    }

    public function getPersonnelHoursSalary (string $time=null) {

        if (is_null($time)) {

            $verta = new Verta();
            $time = $verta->now('asia/tehran')->format('Y-m');
        }

        $_salary = $this->getPersonnelApprovedSalary($time);
        return (($_salary * 1000000) / $this->getApprovedWorkingHours($time));
    }

    public function getApprovedWorkingHours (string $time=null) {

        if (is_null($time)) {

            $verta = new Verta();
            $time = $verta->now('asia/tehran')->format('Y-m');
        }
        
        $exTime = explode('-',$time);
        $_workingHours = TimeTable::where('year',$exTime[0])->where('month',$exTime[1])->select(['totalhours'])->first();

        return $_workingHours->totalhours;
    }

    public function getEntryExitData(string $time=null) {

        if (is_null($time)) {

            $verta = new Verta();
            $time = $verta->now('asia/tehran')->format('Y-m');
        }

        $exTime = explode('-',$time);
        $_d_end = ($exTime[1] < 7) ? 31 : (($exTime[1] == 12) ? 29 : 30);

        $startDate = Verta::parse("$time-01")->datetime()->format('Y-m-d');
        $endDate = Verta::parse("$time-$_d_end")->datetime()->format('Y-m-d');

        return Traffic::where('personnel_id',$this->getPersonnel()->id)
        ->whereBetween('fingred_at',[$startDate,$endDate])
        ->get();
    }

    public function getPersonalSalary($time,$workingseconds) {

       return $this->getPersonnelHoursSalary($time) * (($workingseconds / 60) / 60);
    }

    public function lastMonth($time = null) {

        $_jalaliNow = '';
        if (is_null($time)) {

            $verta = new Verta();
            $_jalaliNow = $verta->now('asia/tehran')->format('Y-m');
        }

        $exTime = explode('-',$_jalaliNow);

        if ($exTime[1] === 1) {

            $exTime[1] = 12;
            $exTime[0]--;
        } else {

            $exTime[1]--;
        }

        return $exTime[0] . '-' . $exTime[1];
    }


    public function getEntryExitTable($traficlist) {

        foreach ($traficlist as $k => $traffic) {

            $dateTime = explode(' ',$traffic->fingred_at);

            if(!isset($trafficDateList[$dateTime[0]])) {
                $trafficDateList[$dateTime[0]] = [];
            }
            
            array_push($trafficDateList[$dateTime[0]],$dateTime[1]);
        }

        
        $tableRecords = [];

        $counter = 1;
        $ioCount = 1;

        $totalTimes = 0;

        foreach ($trafficDateList as $date => $times) {

            if (($countRecord = count($times)) > $ioCount) {
                $ioCount = $countRecord;
            }
        }

        
        foreach ($trafficDateList as $date => $times) {

            $record = [$counter++,$date];
            $record = array_merge($record,$times);

            $timeCount = count($times);

            for($i=0;$i<=($ioCount - $timeCount);$i++) {
                array_push($record,null);
            }
 
            if ($timeCount & 1) {
                $totalTimes += 16200; // 04:30
                $recordTime = "inComplete : 04:30";
            } else {

                $recordTotalTime = 0;
                foreach ($times as $index => $time) {

                    if ($index & 1) {
                        continue;
                    }

                    $recordTotalTime += strtotime($times[$index + 1]) - strtotime($time);
                    
                }

                $totalTimes += $recordTotalTime;
                $recordTime = gmdate('H:i:s',$recordTotalTime);
            }

            array_push($record,$recordTime);
            array_push($tableRecords,$record);        
        }


        $ioCount = ($ioCount & 1) ? (++$ioCount / 2) : ($ioCount / 2) ;
        $tableHeader = ['#','Date'];
        
        for($i=1;$i<=$ioCount;$i++) {
            array_push($tableHeader,'Entry','Exit');
        }

        array_push($tableHeader,'Time');


        return [
            'table' => [
                'header' => $tableHeader,
                'rows' => $tableRecords,
            ],
            'totalseconds' => $totalTimes,
            'total' => $this->getTotalTraficTime($totalTimes)
        ];
    }

    private function getTotalTraficTime($seconds) {

        $H = floor($seconds / 3600);
        $i = ($seconds / 60) % 60;
        $s = $seconds % 60;

        return "$H:$i:$s";
    }
}