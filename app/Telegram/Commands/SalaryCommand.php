<?php 

namespace App\Telegram\Commands;

use App\Telegram\CommandInputHelper;
use Telegram\Bot\Commands\Command;
use Hekmatinasser\Verta\Verta;
use App\Services\HRCalc;
use Illuminate\Support\Facades\Lang;
use Telegram\Bot\Api as Telegram;

class SalaryCommand extends Command
{

    use CommandInputHelper;

    protected string $name = 'salary';
    protected string $description = 'Start Command to get you started';

    protected $hr = null;

    public function handle()
    {

        // $this->hr = HRCalc::user($this->getUser());
        // $this->calcSalary($this->hr->lastMonth());
    }

    public function calcSalary($time) {

        $exTime = $exTime = explode('-',$time);

        $traffic = $this->hr->getEntryExitData($time);
        $calcHours = $this->hr->getEntryExitTable($traffic);

        $this->replyWithHTML('telegram.salary',[

            'table' => $calcHours['table'],
            'firstname' => $this->hr->getPersonnel()->firstname,
            'month' => Lang::get('telegram.months-jalali')[$exTime[1]],
            'year' => $exTime[0],
            'totalhours' => $this->hr->getApprovedWorkingHours(),
            'approvedsalary' => $this->hr->getPersonnelApprovedSalary($time),
            'totalworkinghours' => $calcHours['total'],
            'hourssalary' => $this->hr->getPersonnelHoursSalary(),
            'salary' => $this->hr->getPersonalSalary($time,$calcHours['totalseconds'])

        ]);
    }
   
}