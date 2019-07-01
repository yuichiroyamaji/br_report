<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Report;
use Carbon\Carbon;
use App\Items\Constances;

class Report extends Model
{
    protected $table = 'reports';

    protected $fillable = [
    	'id',
		'date',
		'total_sales',
		'net_sales',
		'remained_cash',
		'cash_sales',
		'credit_sales',
		'net_credit_sales',
		'no_guest_flg',
		'01_staff',
		'01_total_pay',
		'01_reg_hours',
		'01_accom_hours',
		'01_drink_no',
		'01_bottle_pay',
		'01_bonus_pay',
		'01_memo',
		'02_staff',
		'02_total_pay',
		'02_reg_hours',
		'02_accom_hours',
		'02_drink_no',
		'02_bottle_pay',
		'02_bonus_pay',
		'02_memo',
		'03_staff',
		'03_total_pay',
		'03_reg_hours',
		'03_accom_hours',
		'03_drink_no',
		'03_bottle_pay',
		'03_bonus_pay',
		'03_memo',
		'04_staff',
		'04_total_pay',
		'04_reg_hours',
		'04_accom_hours',
		'04_drink_no',
		'04_bottle_pay',
		'04_bonus_pay',
		'04_memo',
		'05_staff',
		'05_total_pay',
		'05_reg_hours',
		'05_accom_hours',
		'05_drink_no',
		'05_bottle_pay',
		'05_bonus_pay',
		'05_memo',
		'expense_flg',
		'01_expense',
		'01_expense_pay',
		'01_expense_memo',
		'02_expense',
		'02_expense_pay',
		'02_expense_memo',
		'03_expense',
		'03_expense_pay',
		'03_expense_memo',
		'04_expense',
		'04_expense_pay',
		'04_expense_memo',
		'05_expense',
		'05_expense_pay',
		'05_expense_memo',
		'delete_flg',
		'created_at',
		'updated_at',
		'deleted_at'
    ];

    public static function existCheck($date){

    }

    public static function updateReport($date){
    	
    }

    public static function insertReport($date){
    	
    }

    public static function missingReport($term){
    	$today = Carbon::today();
    	$start_date = self::setStartDate($term);
    	while(true){
    		$dates[] = $start_date->format('Y-m-d');
    		if($start_date == $today){break;}
    		$start_date = $start_date->addDay();
    	}
    	$start_date = self::setStartDate($term);
    	$result = self::where([    		
    		['date', '>=', $start_date],
    		['delete_flg', 0]
    	])->select('date')->get();    	
    	$reported_dates = $result->pluck('date')->toArray();
    	$arr_diffs = array_diff($dates, $reported_dates);
    	$days = Constances::$days;
    	foreach($arr_diffs as $arr_diff){
    		$dt = Carbon::parse($arr_diff);
    		$day = $dt->dayOfWeek;
    		$diffs[] = $arr_diff.'('.$days[$day].')';
    	}
    	return $diffs;
    }

    public static function setStartDate($term){
    	if($term == 'week'){
    		$start_date = Carbon::today()->subWeek();
    	}else{
    		$start_date = Carbon::today()->subMonth();
    	}
    	return $start_date;
    }
}
