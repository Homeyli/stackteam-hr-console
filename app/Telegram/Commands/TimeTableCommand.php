<?php 

namespace App\Telegram\Commands;

use App\Telegram\CommandInputHelper;
use Telegram\Bot\Commands\Command;


use Hekmatinasser\Verta\Verta;

use App\Models\TimeTable;
use Illuminate\Support\Facades\Lang;

use App\Services\HRCalc;

class TimeTableCommand extends Command
{

    use CommandInputHelper;

    protected string $name = 'timetable';
    protected string $description = 'Start Command to get you started';


    public function handle()
    {

        // get now jalali date ..
        // $verta = new Verta();
        // $_jalaliNow = $verta->now('asia/tehran')->format('Y-m');
        // $jalaliNow = explode('-',$_jalaliNow);

        // $hr = HRCalc::user($this->getUser());

        // // fech time table for date!
        // $timeTable = TimeTable::select([
        //     'month','totaldays','fridays','holidays','workdays','totalhours'
        // ])->where('year',$jalaliNow[0])
        // ->get();

        // // replace number to text month
        // foreach ($timeTable as $index => $item) {
        //     $item['month'] = Lang::get('telegram.months')[$item['month']];
        //     $timeTable[$index] = array_values($item->toArray());
        // }

        // $table = ['header' => Lang::get('telegram.timetableheader'),'rows' => $timeTable->toArray()];
        
        // $this->replyWithHTML('telegram.timetable',[
        //     'table' => $table,
        //     'month' => Lang::get('telegram.months-jalali')[$jalaliNow[1]],
        //     'year' => $jalaliNow[0],
        //     'totalhours' => $timeTable[$jalaliNow[1]-1][5],
        //     'salary' => $hr->getPersonnelApprovedSalary(),
        //     'hourssalary' => $hr->getPersonnelHoursSalary(),
        //     'firstname' => $hr->getPersonnel()->firstname
        // ]);

    }






}