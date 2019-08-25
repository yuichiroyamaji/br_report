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
use App\Items\Constances;

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

    // 他のサービスをコンストラクトでインスタンス生成する例（今回は結局呼び出してない）
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
            // $to = Constances::OWNER_EMAIL;
            $to = Constances::SYSTEM_ADMIN_EMAIL;
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
            // $result = $this->emailSendService->send($to, $subject, $message);
            $result = EmailSendService::send($to, $subject, $message);
            if($result){Log::info('月次報告送信完了');}      
        }catch(Exception $e){
            Log::error('レポート未提出日送信エラー: '.$e);
        }
    }
}
