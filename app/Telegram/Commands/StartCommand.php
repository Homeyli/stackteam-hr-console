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
        
        print_r($this->getUpdate());die();
        $this->replyWithMessage([
            'text' => "سلام زهرا، به چت بات مدیریت پرسونلی استک تیم خوش آمدی ",
        ]);

        $nathnalcode = $this->askWithMessage('زهرا جان، لطفا کد ملی خودت رو بنویس');
        $b = $this->askWithMessage('متولد کجا هستی ؟');
        $b = $this->askWithMessage("تاریخ تولدت رو با پترن مشابه 23-05-1369 وارد کن ؟");


    }


    protected function getUser() {

    }

}