<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Items\Constances;

class EmailSendService{

    public static function reportMsg(){
        
    }
    
    public static function missingReportMsg(){
        
    }
    
    public static function shiftMsg($year, $month, $shifts){
        $to      = Constances::OWNER_EMAIL.','.Constances::SYSTEM_ADMIN_EMAIL;
        $subject = '【シフト報告】 '.$year.'年'.$month.'月度';
        $message = '';
        foreach($shifts as $shift){
            $message .= $shift['date'].' ';
            if(isset($shift['str_staff'])){$message .= $shift['str_staff'];}
            if(isset($shift['event'])){$message .= ' 【'.$shift['event'].'】';}
            $message .= "\r\n";
        }
        self::send($to,$subject,$message);
        return true;
    }

    public static function send($to,$subject,$message,$cc = null){
    	//メールの送信
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        $headers = 'From: no-reply@br.com'."\r\n";
        if($cc){
            $headers .= 'Cc: '.$cc."\r\n";
        }
        $headers .= 'Bcc: '.Constances::SYSTEM_ADMIN_EMAIL."\r\n";
        mb_send_mail($to, $subject, $message, $headers);        
        LOG::info('TO: '.$to);
        if($cc){
            LOG::info('CC: '.$cc);
        }
        LOG::info('HEADER: '.$headers);
        LOG::info('SUBJECT: '.$subject);
        LOG::info('MESSAGE: '.$message);
        return true;
    }
}