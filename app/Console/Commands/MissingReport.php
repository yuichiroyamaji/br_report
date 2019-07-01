<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Services\EmailSendService;
use App\Report;

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
        $missed_reports = Report::missingReport('month');
        // Log::info($missed_reports);
        $day = Constances::$days;
        $week = date("w",mktime(0,0,0,$month,$date,$year));
        $dates = $year.'年'.$month.'月'.$date.'日('.$day[$week].')';
        $subject = '【'.$report_type.'報告】'.$dates;
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
        $message .= $message."\r\n";
        
        $result = $this->emailSendService->send($subject, $message);
        Log::info($result);
    }
}
