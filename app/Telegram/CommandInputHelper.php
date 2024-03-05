<?php

namespace App\Telegram;

use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\BotUser;
use Telegram\Bot\Keyboard\Keyboard;
trait CommandInputHelper {

    private ?BotUser $user = null;
    
    public function replyKeyboardMarkup(array $params) { return Keyboard::make($params); }

    protected function replyWithTable ($headers,$rows) {

        $_tbl = $rows;
        array_unshift($_tbl,$headers);;

        $_rowlens = [];
        
        foreach ($_tbl as $row) {
            foreach ($row as $index => $value) {
                $_rowlens[$index] = !isset($_rowlens[$index]) ? strlen($value) : (strlen($value) > $_rowlens[$index] ? strlen($value) : $_rowlens[$index]);
            }
        }

        $output = '';
        $_line = '';

        foreach($_rowlens as $total) {
            $_line .= '+' . str_repeat('-',$total + 2) ;
        } 
        $_line .= "+\n";

        foreach ($_tbl as $key => $row) {

            $output .= (!$key || $key === 1) ? $_line : '';

            foreach ($row as $index => $value) {


                $rLen = ($_rowlens[$index] - strlen($value)) +1;
                $output .= '| ' . $value . str_repeat(' ',$rLen);
            }

            $output .= "|\n";
        }

        $output .= $_line;

        return $this->getTelegram()->sendMessage([
            
            'chat_id' => $this->getUpdate()->getMessage()->from->id,
            'text' => "<pre>$output</pre>",
            'parse_mode' => 'html'
        ]);
    }

    
    protected function replyWithHTML ($html,$viewdata=[],$request=[]) {

        
        if(view()->exists($html)) {
            $html = view($html,$viewdata)->render();
        }

        return $this->replyWithMessage(array_merge($request,[
            'text' => $html,
            'parse_mode' => 'html'
        ]));

    }

    
    
    public function askWithMessage($text,$request=[]) {

        $this->replyWithMessage(array_merge($request,['text' => $text]));


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