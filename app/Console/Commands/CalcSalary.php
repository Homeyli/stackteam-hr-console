<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Personnel;
use App\Models\Traffic;
use Hekmatinasser\Verta\Verta;

class CalcSalary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc:salary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $_personnels = Personnel::where('is_active',true)->get();

        $personnelList = [];
        $personnelObject = [];

        foreach ($_personnels as $k => $personnel) {

            $strName = "$personnel->en_name\t#$personnel->devicecode";
            $personnelList[$personnel->id] = $strName;
            $personnelObject[$strName] = $personnel;
        }

        //print_r($personnelList);die();
        $selected_pesonnel = $this->choice("select the personnel : ",$personnelList);

        unset($_personnels);
        unset($personnelList);

        //print_r($personnelObject[$selected_pesonnel]->toArray());die();
        
        $time = $this->calcTime($personnelObject[$selected_pesonnel]);
        $salary = $this->calcSalary($time,$personnelObject[$selected_pesonnel]); 


    }

    private function choseTrafficTimeFream (Personnel $personnel) {

        $month = [1 => 'farvardin','ordibehest','khordad','tir','mordad','shahrivar','mehr','aban','azar','day','bahman','esfand'];

        $_y = (int)$this->choice("Select Year :",[1401,1402,1403,'custom time']);
        $_m = array_search ($this->choice("Select Year :",$month), $month);
        
        $_d_end = ($_m < 7) ? 31 : 30;

        $startDate = Verta::parse("$_y-$_m-01")->datetime()->format('Y-m-d');
        $endDate = Verta::parse("$_y-$_m-$_d_end")->datetime()->format('Y-m-d');

        //$this->error(Verta::parse($_end_date)->datetime()->format('Y-m-d'));die();

        return Traffic::where('personnel_id',$personnel->id)
            ->whereBetween('fingred_at',[$startDate,$endDate])
            ->get();
        
    }

    protected function calcTime(Personnel $personnel) {

        // get all traffics
        $_trafficList = $this->choseTrafficTimeFream($personnel);
        $trafficDateList = [];

        foreach ($_trafficList as $k => $traffic) {

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

        $this->table($tableHeader,$tableRecords);
        $this->info("total seconds : " . $totalTimes);
        $this->info ("total : " . $this->getTotalTraficTime($totalTimes));

        return $totalTimes;
    }

    protected function calcSalary($time,Personnel $personnel) {

        $salary = $personnel->salary * 1000000;
        $secondSalary = $salary / (192 * 60 * 60);

        $calcedSalary = $time * $secondSalary;

        $this->error('Base Salary is #' . $salary . " IRR");
        $this->error('Total Salary is ' . ($calcedSalary * 10) . " IRR");
    }

    private function getTotalTraficTime($seconds) {

        $H = floor($seconds / 3600);
        $i = ($seconds / 60) % 60;
        $s = $seconds % 60;

        return "$H:$i:$s";
    }

}
