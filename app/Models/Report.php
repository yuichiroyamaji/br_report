<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Report;
use Carbon\Carbon;
use App\Services\DayService;
use Log;
use DB;

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

    public static function deletePastReport($date){
    	$where = [['date', $date], ['expense_flg', '<>', 1]];
    	if(self::where($where)->get()->isNotEmpty()){
    		self::where($where)->update(['delete_flg' => 1, 'deleted_at' => Carbon::now()]);
    	}
    }

    public static function scopeColumns(){
    	return DB::table('information_schema.columns')->where('TABLE_NAME', 'reports')->get();
    }

	public static function getThisMonthRecord($year, $month){
    	return self::whereYear('date', $year)->whereMonth('date', $month)->where('delete_flg', 0)->get();
    }

    public static function insertReport($input){
    	self::insert($input);
    }

    public static function missingReport($from_date, $to_date){
    	$start_date = clone $from_date;
    	$end_date = clone $to_date;
    	while(true){
    		$dates[] = $start_date->format('Y-m-d');
    		if($start_date == $end_date){break;}
    		$start_date = $start_date->addDay();
    	}
    	$reported_dates = self::where([    		
    		['date', '>=', $from_date->format('Y-m-d')],   		
    		['date', '<=', $to_date->format('Y-m-d')],
    		['delete_flg', 0]
    	])->select('date')->pluck('date')->toArray();
    	$arr_diffs = array_diff($dates, $reported_dates);
    	$days = DayService::$days;
    	foreach($arr_diffs as $arr_diff){
    		$dt = Carbon::parse($arr_diff);
    		$day = $dt->dayOfWeek;
    		$diffs[] = $arr_diff.'('.$days[$day].')';
    	}
    	return $diffs;
    }
}
