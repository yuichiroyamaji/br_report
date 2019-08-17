<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Services\EmailSendService;
use App\Report;
use App\User;
use App\Services\DayService;
use Carbon\Carbon;

class MissingReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:missingreport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description:notify missing report on weekly basis';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $emailSendService;
    public function __construct(EmailSendService $email_send_service)
    {
        parent::__construct();
        $this->emailSendService = $email_send_service;
    }

    // public function __construct()
    // {
    //     parent::__construct();
    // }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('レポート未提出日送信開始');
        try{
            // $users = User::getAllUsers();
            // $to = $users->where('name', 'yoshie')->pluck('email')->first();
            // $to = $users->where('name', 'yuichiro')->pluck('email')->first();
            $to = 'Y.071081010622@icloud.com';
            $days = DayService::$days;
            $day_ago = DayService::setDate('day');
            $week_ago = DayService::setDate('week');
            $week_day_ago = clone $week_ago;
            $week_day_ago = $week_day_ago->subDay();
            $month_ago = DayService::setDate('month');
            $term_week = $week_ago->format('Y/m/d').'('.$days[$week_ago->dayOfWeek].')～'.$day_ago->format('Y/m/d').'('.$days[$day_ago->dayOfWeek].')';
            $term_month = $month_ago->format('Y/m/d').'('.$days[$month_ago->dayOfWeek].')～'.$week_day_ago->format('Y/m/d').'('.$days[$week_day_ago->dayOfWeek].')';
            $subject = '【レポート未提出日報告】 '.$term_week;
            $message = '----------------------------------'."\r\n";
            $message .= '▼先週分'."\r\n";
            $message .= $term_week."\r\n";
            $message .= '----------------------------------'."\r\n";
            $missed_reports_week = Report::missingReport($week_ago, $day_ago);
            foreach($missed_reports_week as $report){
                $message .= $report."\r\n";
            }
            $message .= "\r\n";
            $message .= '----------------------------------'."\r\n";
            $message .= '▼過去30日分'."\r\n";
            $message .= $term_month."\r\n";
            $message .= '----------------------------------'."\r\n";
            $missed_reports_month = Report::missingReport($month_ago, $week_day_ago);
            foreach($missed_reports_month as $report){
                $message .= $report."\r\n";
            }
            $result = $this->emailSendService->send($to, $subject, $message);            
        }catch(Exception $e){
            Log::error('レポート未提出日送信エラー: '.$e);
        }
        Log::info('レポート未提出日送信完了');
    }
}
