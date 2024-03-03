<?php 

namespace App\Telegram\Commands;

use App\Telegram\CommandInputHelper;
use Telegram\Bot\Commands\Command;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Console\OutputStyle;
use Illuminate\Contracts\Support\Arrayable;


class TimeTableCommand extends Command
{

    use CommandInputHelper;

    protected string $name = 'timetable';
    protected string $description = 'Start Command to get you started';

    /**
     * The output interface implementation.
     *
     * @var \Illuminate\Console\OutputStyle
     */
    public string $output ;

    public function handle()
    {


        $this->replyWithHTML('telegram.test');

        // $this->replyWithTable(['#','Firstname','Lastname','Entry','Exit'],[
        //     ['1',"Mehdi",'Homeily','No Entry i\'m Owner!','No Eqit']
        // ]);

    }






}