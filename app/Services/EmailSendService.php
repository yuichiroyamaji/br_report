<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Items\Constances;

class EmailSendService{
    public function send($subject,$message){
    	//メールの送信
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        $to      = 'Y.071081010622@icloud.com';
        // $to      = 'yuichiroyamaji@hotmail.com';
        // $message = '('.Carbon::now().'時点)'."\r\n";
        $headers = 'From: no-reply@br.com'."\r\n";
        $headers .= 'Bcc: yuichiroyamaji@hotmail.com'."\r\n";
        mb_send_mail($to, $subject, $message, $headers);
        Log::info($msg);
        return true;
    }
}