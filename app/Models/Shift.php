<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Report;
use Carbon\Carbon;
use App\Services\DayService;
use App\User;
use Log;
use DB;

class Shift extends Model
{
    const TABLENAME = 'shifts';
    protected $table = self::TABLENAME;
    
    public static function getMonthShifts($date){
    	//User情報をDBから取得
    	$users = User::getAllUsers();
    	//対象月のシフト情報を取得
    	$shifts = self::whereYear('date', $date->year)->whereMonth('date', $date->month)->where('delete_flg', 0)->get();
    	//対象月の最終日を設定
    	$last_date = (string)$date->day;
    	//パラメータを設定
    	for($i=1; $i<=$last_date; $i++){
    		$day = $i == 1 ? $date->firstOfMonth() : $date->addDay();
    		$param[$i]['date'] = (string)$day->format('m/d').'('.DayService::getDays($day->dayOfWeek).')';
    		$target_shift = $shifts->where('date', (string)$day->format('Y-m-d'));
    		if($target_shift->isNotEmpty()){
				for($h=1; $h<=5; $h++){
					$staff_id = $target_shift->pluck(sprintf('%02d', $h).'_staff')->first();
					if(!$staff_id){break;}
					$param[$i]['selected'][] = $users->where('id', $staff_id[0])->pluck('id')->first();
				}
    		}else{
    			$param[$i]['selected'] = NULL;
    		}
    		$param[$i]['event'] = $target_shift->pluck('event')->first();
    	}
    	return $param;
    }

}
