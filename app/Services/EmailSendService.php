<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Items\Constances;

class EmailSendService{
    public function send($msg){
    	//メールの送信
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        // $msg = '';
        // $msg_html = '';
        // foreach($mail_msg as $key => $value){
        //     foreach($column as $col){
        //         if($key == $col->{'COLUMN_NAME'}){
        //             if($value != null){
        //                 $msg .= '['.$col->{'COLUMN_COMMENT'}.'] '.$value."\r\n";
        //                 $msg_html .= '['.$col->{'COLUMN_COMMENT'}.'] '.$value.",";
        //             }
        //             $skip = true;
        //             break;
        //         }
        //     }
        //     if($skip){continue;}    
        //     $msg .= '['.$key.'] '.$value."\r\n";
        //     $msg_html .= '['.$key.'] '.$value.",";
        // }
        // $msg_html = explode(',', $msg_html);
        $day = ['日', '月', '火', '水', '木', '金', '土'];
		$week = date("w",mktime(0,0,0,$month,$date,$year));
        $dates = $year.'年'.$month.'月'.$date.'日('.$day[$week].')';

        $to      = 'Y.071081010622@icloud.com';
        // $to      = 'yuichiroyamaji@hotmail.com';
        $subject = '【'.$report_type.'報告】'.$dates;
        // $message = '('.Carbon::now().'時点)'."\r\n";
        $message = '------------------------------'."\r\n";
        $message .= $year.'年'.$month.'月度実績'."\r\n";
        $message .= '------------------------------'."\r\n";
        $message .= '総売上げ額： '.$total_sales.'円'."\r\n";
        $message .= '総純利益額： '.$net_sales.'円'."\r\n";
        $message .= '(総カード売上： '.$credit_sales.'円)'."\r\n";
        $message .= '(総人件費： '.$total_labor_cost.'円)'."\r\n";
        $message .= '(総経費： '.$total_expense_cost.'円)'."\r\n";
        $message .= "\r\n";
        $message .= '------------------------------'."\r\n";
        $message .= $report_type.'報告内容'."\r\n";
        $message .= '------------------------------'."\r\n";
        $message .= $msg."\r\n";
        $headers = 'From: no-reply@br.com'."\r\n";
        $headers .= 'Bcc: yuichiroyamaji@hotmail.com'."\r\n";
        mb_send_mail($to, $subject, $message, $headers);
        Log::info($msg);
        return true;
    }
}