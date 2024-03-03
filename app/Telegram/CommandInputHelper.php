<?php

namespace App\Telegram;

use Telegram\Bot\Laravel\Facades\Telegram;

trait CommandInputHelper {


    public function replyWithTableMessage($table,$text) {

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
}