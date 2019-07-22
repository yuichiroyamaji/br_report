<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // カスタムif文の定義
        Blade::if('env', function ($environment) {
            return app()->environment($environment);
        });
        // SQLログ出力
        \DB::listen(function ($query) {
            $sql = $query->sql;
            for ($i = 0; $i < count($query->bindings); $i++) {
                $sql = preg_replace("/\?/", $query->bindings[$i], $sql, 1);
            }
            \Log::info($sql);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\DayService');
        $this->app->bind('App\Services\EmailSendService');
        setlocale(LC_ALL, 'ja_JP.UTF-8');
        Carbon::setLocale('ja');
    }
}
