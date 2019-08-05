<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\User;
use Carbon\Carbon;
use App\Services\DayService;

class testController extends Controller
{
    public function handle(){

        echo Carbon::now()->formatLocalized('%Y年%m月%d日(%a)');
        exit;
        
    	// $date = date('d');
	    // $test = Report::missingReport('month');
	    // // $test = new Report;
	    // echo '<pre>';
	    // var_dump($test);
	    // echo '</pre>';
	    // echo $test;
	    // $users = User::getAllUsers();
	    // echo '<pre>';
	    // var_dump($users->where('name', 'yoshie')->pluck('email')->first());
	    // echo '</pre>';
	    
     //    $users = User::getAllUsers();
     //    $to = $users->where('name', 'yoshie')->pluck('email')->first();
     //    $bcc = $users->where('name', 'yuichiro')->pluck('email')->first();
     //    $days = DayService::$days;
     //    $day_ago = DayService::setDate('day');
     //    $week_ago = DayService::setDate('week');
     //    $week_day_ago = clone $week_ago;
     //    $week_day_ago = $week_day_ago->subDay();
     //    $month_ago = DayService::setDate('month');
     //    $term_week = $week_ago->format('Y/m/d').'('.$days[$week_ago->dayOfWeek].')～'.$day_ago->format('Y/m/d').'('.$days[$day_ago->dayOfWeek].')';
     //    $term_month = $month_ago->format('Y/m/d').'('.$days[$month_ago->dayOfWeek].')～'.$week_day_ago->format('Y/m/d').'('.$days[$week_day_ago->dayOfWeek].')';
     //    $subject = 'レポート未提出日 [期間：'.$term_week.']';
     //    $message = '------------------------------'."\r\n";
     //    $message .= '先週分未提出日['.$term_week."]\r\n";
     //    $message .= '------------------------------'."\r\n";
	    // $missed_reports_week = Report::missingReport($week_ago, $day_ago);
     //    foreach($missed_reports_week as $report){
    	// 	$message .= $report."\r\n";
    	// }
     //    $message .= "\r\n";
     //    $message .= '------------------------------'."\r\n";
     //    $message .= '過去30日分未提出日['.$term_month."]\r\n";
     //    $message .= '------------------------------'."\r\n";
     //    $missed_reports_month = Report::missingReport($month_ago, $week_day_ago);
     //    foreach($missed_reports_month as $report){
    	// 	$message .= $report."\r\n";
    	// }
     //    $message .= "\r\n";
     //    echo 'TO: '.$to.'<br>';
     //    // echo 'BCC: '.$bcc.'<br>';
     //    echo 'SUBJECT: '.$subject.'<br>';
     //    echo 'MESSAGE: <br>'.$message.'<br>';
     //    exit;
     //    $result = $this->emailSendService->send($to, $bcc, $subject, $message);
     //    Log::info($result);

	}
}
