<?php 

namespace App\Telegram\Commands;

use App\Telegram\CommandInputHelper;
use Telegram\Bot\Commands\Command;
use Hekmatinasser\Verta\Verta;
use App\Services\HRCalc;
use Illuminate\Support\Facades\Lang;
use Telegram\Bot\Api as Telegram;

class RewardYearCommand extends Command
{

    use CommandInputHelper;

    protected string $name = 'rewardyear';
    protected string $description = 'Start Command to get you started';

    protected $hr = null;

    public function handle()
    {

        $this->hr = HRCalc::user($this->getUser());
        
        $totaltime = 2120;
        $allsec = 0;
        for($i = 4;$i<=12;$i++) {

            $o = $this->hr->getEntryExitData('1402-' . $i);
            $calcHours = $this->hr->getEntryExitTable($o);

            $allsec += $calcHours['totalseconds'];
            //die($this->getTotalTraficTime($calcHours['totalseconds']));
        }

        $h = $this->getTotalTraficH($allsec);
        $reward = ((7300000 * $h)) / $totaltime;

        $this->replyWithHTML('telegram.reward',[

            'totaltime' => $totaltime,
            'totalh' => $h,
            'reward' => $reward 

        ]);
    }

    private function getTotalTraficTime($seconds) {

        $H = floor($seconds / 3600);
        $i = ($seconds / 60) % 60;
        $s = $seconds % 60;

        return "$H:$i:$s";
    }

    private function getTotalTraficH($seconds) {

        $H = floor($seconds / 3600);
        $i = ($seconds / 60) % 60;
        $s = $seconds % 60;

        return "$H";
    }

    

    public function calcSalary($time) {

        $exTime = explode('-',$time);

        
        $traffic = $this->hr->getEntryExitData($time);
        //print_r($traffic );die();
        $calcHours = $this->hr->getEntryExitTable($traffic);

        $this->replyWithHTML('telegram.salary',[

            'table' => $calcHours['table'],
            'firstname' => $this->hr->getPersonnel()->firstname,
            'month' => Lang::get('telegram.months-jalali')[$exTime[1]],
            'year' => $exTime[0],
            'totalhours' => $this->hr->getApprovedWorkingHours($time),
            'approvedsalary' => $this->hr->getPersonnelApprovedSalary($time),
            'totalworkinghours' => $calcHours['total'],
            'hourssalary' => $this->hr->getPersonnelHoursSalary($time),
            'salary' => $this->hr->getPersonalSalary($time,$calcHours['totalseconds'])

        ]);
    }
   
}