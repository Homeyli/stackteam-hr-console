<?php

namespace App\Telegram;

use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\BotUser;

trait CommandInputHelper {

    private ?BotUser $user = null;
    
    protected function replyWithTable ($text) {

        return $this->getTelegram()->sendMessage([
            
            'chat_id' => $this->getUpdate()->getMessage()->from->id,
            'text' => $text,
            'parse_mode' => 'html'
        ]);
    }

    
    
    public function askWithMessage($text) {

        $this->replyWithMessage([
            'text' => $text,
        ]);

        return $this->receiveData(); 

    }


    private function receiveData() {

        while(true) {

            $params = [];
            $params['offset'] = $this->getUpdate()->update_id + 1;
            $params['limit'] = 1;

            $response =  Telegram::getUpdates($params, false);

            if (isset($response[0])) {

                $params['offset']++;
                Telegram::getUpdates($params, false);

                return $response[0]->getMessage()->text;
            }

            usleep(100);
        }
    }

    protected function getUser() {

        if (is_null ($this->user)) {

            $this->user = BotUser::updateOrCreate(
                ['telegram_id' => $this->getUpdate()->getMessage()->from->id],
                [
                    // Update or create data
                    'username' => $this->getUpdate()->getMessage()->from->username,
                    'first_name' => $this->getUpdate()->getMessage()->from->first_name,
                    'last_name' => $this->getUpdate()->getMessage()->from->last_name,
                    'is_bot' => $this->getUpdate()->getMessage()->from->is_bot,

                ]
            );
        }

        return $this->user;
    }
}