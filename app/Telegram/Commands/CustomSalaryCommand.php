<?php 

namespace App\Telegram\Commands;

use App\Telegram\CommandInputHelper;
use Telegram\Bot\Commands\Command;
use Hekmatinasser\Verta\Verta;
use App\Services\HRCalc;
use Illuminate\Support\Facades\Lang;
use Telegram\Bot\Api as Telegram;

class CustomSalaryCommand extends Command
{

    use CommandInputHelper;

    protected string $name = 'customsalary';
    protected string $description = 'Start Command to get you started';

    protected $hr = null;

    public function handle()
    {

        $this->hr = HRCalc::user($this->getUser());
        
        $reply_markup = $this->replyKeyboardMarkup([
            'keyboard' => Lang::get('telegram.months-keyboard'),
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        $result = $this->askWithMessage('لطفا ماه مورد نظر را وارد کنید',[
            'reply_markup' => $reply_markup
        ]);

        $verta = new Verta();
        $month = array_search($result,Lang::get('telegram.months-jalali'));
        $year = $time = $verta->now('asia/tehran')->format('Y');
    
        $time = "$year-$month";

        $this->calcSalary($time);
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
            'totalhours' => $this->hr->getApprovedWorkingHours($time),
            'approvedsalary' => $this->hr->getPersonnelApprovedSalary($time),
            'totalworkinghours' => $calcHours['total'],
            'hourssalary' => $this->hr->getPersonnelHoursSalary($time),
            'salary' => $this->hr->getPersonalSalary($time,$calcHours['totalseconds'])

        ]);
    }
   
}