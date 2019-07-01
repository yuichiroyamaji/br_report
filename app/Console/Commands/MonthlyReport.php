<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MonthlyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:monthlyreport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commands description:monthlyreport 17:30';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //2
        // mb_send_mail('yuichiroyamaji@hotmail.com', 'test', 'test', 'From: no-reply@br.com');
        Log::info('ログ出力テスト');

    }
}
