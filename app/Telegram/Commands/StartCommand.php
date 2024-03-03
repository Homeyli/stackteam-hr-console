<?php 

namespace App\Telegram\Commands;

use App\Telegram\CommandInputHelper;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{

    use CommandInputHelper;

    protected string $name = 'start';
    protected string $description = 'Start Command to get you started';


    public function handle()
    {
        
        $this->replyWithHTML('telegram.start',[
            'name' => $this->getUser()->first_name
        ]);

    }

}