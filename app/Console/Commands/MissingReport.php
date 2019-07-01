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
        $result = $this->emailSendService->send('hello!');
        Log::info($result);
    }
}
