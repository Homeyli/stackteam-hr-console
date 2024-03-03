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
        // $this->output = $this->table(['#id','Firstname','Lastname'],[
        //     ['1','Mehdi','Homeily'],
        //     ['1','amir','askari']
        // ]);


        //$this->replyWithTable("<pre>" . $this->output . "</pre>");
        $view = view('telegram.test');
        $this->replyWithTable($view->render());

    }


    public function table($headers, $rows)
    {
        $output = '';
        $mask = "|%5s |%-30s | x |\n";

        $output .= sprintf($mask, ['Num', 'Title']);
        $output .= sprintf($mask, '1', 'A value that fits the cell');
        $output .= sprintf($mask, '2', 'A too long value that will brake the table');

        return $output;
    }



}