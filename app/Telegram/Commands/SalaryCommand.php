<?php 

namespace App\Telegram\Commands;

use App\Telegram\CommandInputHelper;
use Telegram\Bot\Commands\Command;
use Hekmatinasser\Verta\Verta;
use App\Services\HRCalc;
use Illuminate\Support\Facades\Lang;

class SalaryCommand extends Command
{

    use CommandInputHelper;

    protected string $name = 'salary';
    protected string $description = 'Start Command to get you started';


    public function handle()
    {


        $hr = HRCalc::user($this->getUser());
        $time = $hr->lastMonth();
        $exTime = $exTime = explode('-',$time);

        $traffic = $hr->getEntryExitData($time);
        $calcHours = $hr->getEntryExitTable($traffic);



        $this->replyWithHTML('telegram.salary',[

            'table' => $calcHours['table'],
            'firstname' => $hr->getPersonnel()->firstname,
            'month' => Lang::get('telegram.months-jalali')[$exTime[1]],
            'year' => $exTime[0],
            'totalhours' => $hr->getApprovedWorkingHours(),
            'approvedsalary' => $hr->getPersonnelApprovedSalary($time),
            'totalworkinghours' => $calcHours['total'],
            'hourssalary' => $hr->getPersonnelHoursSalary(),
            'salary' => $hr->getPersonalSalary($time,$calcHours['totalseconds'])
        ]);
    }

    
   
}