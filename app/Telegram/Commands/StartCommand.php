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
        $this->replyWithMessage([
            'text' => $this->getUser()->username,
        ]);
        
        $this->replyWithMessage([
            'text' => "سلام :name، به چت بات مدیریت پرسونلی استک تیم خوش آمدی \n\nاز طریق این چت بات میتونید خدمات پرسونلی زیر رو دریافت کنید، برای شروع روی لینک کلیک/تاچ کنید :\n\n1. /timetable جدول موظف کاری\n2. /calcsalary محاسبه حقوق و دستمزد\n3. /workreport ثبت گذارش کار روزانه\n4. /editprofile ویرایش پروفایل پرسونلی",
        ]);

        // $nathnalcode = $this->askWithMessage('زهرا جان، لطفا کد ملی خودت رو بنویس');
        // $b = $this->askWithMessage('متولد کجا هستی ؟');
        // $b = $this->askWithMessage("تاریخ تولدت رو با پترن مشابه 23-05-1369 وارد کن ؟");

        
        
    }

}