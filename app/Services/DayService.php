<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DayService{
    public static $days = ['日','月','火','水','木','金','土'];    

    public static function setDate($term){
        if($term == 'day'){
            $date = Carbon::today()->subDay();
        }elseif($term == 'week'){
            $date = Carbon::today()->subWeek();
        }elseif($term == 'month'){
            $date = Carbon::today()->subMonth();
        }
        return $date;
    }
}