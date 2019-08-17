<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DayService{
    public $months = [
                        1 => '1', 
                        2 => '2', 
                        3 => '3', 
                        4 => '4', 
                        5 => '5', 
                        6 => '6', 
                        7 => '7', 
                        8 => '8', 
                        9 => '9', 
                        10 => '10', 
                        11 => '11', 
                        12 => '12'
                    ];

    public $years = [
                        2018 => '2018', 
                        2019 => '2019', 
                        2020 => '2020', 
                        2021 => '2021', 
                        2022 => '2022', 
                        2023 => '2023', 
                        2024 => '2024', 
                        2025 => '2025', 
                        2026 => '2026', 
                        2027 => '2027', 
                        2028 => '2028', 
                        2029 => '2029',
                        2030 => '2030'
                    ];

    public static function getDays($day){
         return ['日','月','火','水','木','金','土'][$day];
    }

    public static function separeteDate($today){
        $dates = [
            'year' => $today->year,
            'month' => $today->month,
            'date' => $today->day
        ];
        return $dates; 
    }

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

    public static function getDayCount($month){
        $dates = [
            'year' => $today->year,
            'month' => $today->month,
            'date' => $today->day
        ];
        return $dates; 
    }
}