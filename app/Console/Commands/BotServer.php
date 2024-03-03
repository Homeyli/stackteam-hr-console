<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:server';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        while(true) {

            $update = Telegram::commandsHandler(false);

            if (!empty($update)) {
                
                $this->info("new command recived form telegram bot..");
            }

            usleep(10000);
        }
        
    }
}
