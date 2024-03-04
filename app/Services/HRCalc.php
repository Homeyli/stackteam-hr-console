<?php 


namespace App\Services;
use App\Models\BotUser;

use App\Models\Personnel;

class HRCalc {

    //ew static($datetime, $timezone)

    protected $user = null;
    protected $personnel = null;

    public function __construct(BotUser $user)
    {
        $this->user = $user;
    }

    public static function User(BotUser $user) {
        return new static($user);
    }

    public function getPersonnel() {
        
        if(is_null($this->personnel)) {
            $this->personnel = Personnel::where('is_active',true)->where('bot_user_id',$this->user->id)->first();
        }

        return $this->personnel;
    }
}