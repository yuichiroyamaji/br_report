<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Items\Constances;

class EmailSendService{
    public function send($to,$subject,$message){
    	//メールの送信
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        $headers = 'From: no-reply@br.com'."\r\n";
        $headers .= 'Bcc: '.Constances::SYSTEM_ADMIN_EMAIL."\r\n";
        mb_send_mail($to, $subject, $message, $headers);        
        LOG::info('TO: '.$to);
        LOG::info('HEADER: '.$headers);
        LOG::info('SUBJECT: '.$subject);
        LOG::info('MESSAGE: '.$message);
        return true;
    }
}