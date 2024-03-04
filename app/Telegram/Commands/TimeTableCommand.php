<?php 

namespace App\Telegram\Commands;

use App\Telegram\CommandInputHelper;
use Telegram\Bot\Commands\Command;


use Hekmatinasser\Verta\Verta;

use App\Models\TimeTable;
use Illuminate\Support\Facades\Lang;

class TimeTableCommand extends Command
{

    use CommandInputHelper;

    protected string $name = 'timetable';
    protected string $description = 'Start Command to get you started';


    public function handle()
    {

        // get now jalali date ..
        $verta = new Verta();
        $jalaliNow = $verta->now('asia/tehran')->format('Y-m');
        $jalaliNow = explode('-',$jalaliNow);


        // fech time table for date!
        $timeTable = TimeTable::select([
            'month','totaldays','fridays','holidays','workdays','totalhours'
        ])->where('year',$jalaliNow[0])
        ->get();

        // replace number to text month
        foreach ($timeTable as $index => $item) {
            $item['month'] = Lang::get('telegram.months')[$item['month']];
            $timeTable[$index] = array_values($item->toArray());
        }


        $table = ['header' => Lang::get('telegram.timetableheader'),'rows' => $timeTable->toArray()];
        
        //print_r($timeTable->toArray());die();
        
        $this->replyWithHTML('telegram.timetable',[
            'table' => $table,
            'firstname' => $this->getUser()->first_name
        ]);

        // $this->replyWithTable(['#','Firstname','Lastname','Entry','Exit'],[
        //     ['1',"Mehdi",'Homeily','No Entry i\'m Owner!','No Eqit']
        // ]);

    }






}