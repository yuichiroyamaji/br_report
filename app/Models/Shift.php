<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Report;
use Carbon\Carbon;
use App\Services\DayService;
use Log;
use DB;

class Shift extends Model
{
    const TABLENAME = 'shifts';
    protected $table = self::TABLENAME;
    
    public static function getShift($date){
    	return self::whereYear('date', $date->year)->whereMonth('date', $date->month)->where('delete_flg', 0)->get();
    }

}
