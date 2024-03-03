<?php 

namespace App\Telegram\Commands;

use App\Telegram\CommandInputHelper;
use Telegram\Bot\Commands\Command;

class TimeTableCommand extends Command
{

    use CommandInputHelper;

    protected string $name = 'timetable';
    protected string $description = 'Start Command to get you started';


    public function handle()
    {

        $this->replyWithTable("<pre>\n| Tables   |      Are      |  Cool |\n|----------|:-------------:|------:|\n| col 1 is |  left-aligned | $1600 |\n| col 2 is |    centered   |   $12 |\n| col 3 is | right-aligned |    $1 |\n</pre>");

    }



}