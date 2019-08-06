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

    protected $fillable = [
        'date',
        '01_staff',
        '02_staff',
        '03_staff',
        '04_staff',
        '05_staff',
        'event',
        'dayoff_flg',
        'delete_flg'
    ];
    
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
            $param[$i]['hidden_date'] = (string)$day->format('Y-m-d');
    		$param[$i]['date'] = (string)$day->format('m/d').'('.DayService::getDays($day->dayOfWeek).')';
    		$target_shift = $shifts->where('date', (string)$day->format('Y-m-d'));
    		if($target_shift->isNotEmpty()){                
				for($h=1; $h<=5; $h++){
					$staff_id = $target_shift->pluck(sprintf('%02d', $h).'_staff')->first();
					if(!$staff_id){break;}
					$param[$i]['selected'][] = $users->where('id', $staff_id[0])->pluck('id')->first();
				}
    		}
    		if(!array_has($param[$i], 'selected')){$param[$i]['selected'] = NULL;}
    		$param[$i]['event'] = $target_shift->pluck('event')->first();
    	}
    	return $param;
    }

    public static function updateOrCreate($inputs){        
        $count = count($inputs);
        for($i=1; $i<=$count; $i++){
            if(isset($inputs[$i]['staff'][0]) && $inputs[$i]['staff'][0] == 0){
                $data[$i] = [
                    'date' => $inputs[$i]['hidden_date'],
                    'dayoff_flg' => 1
                ];
            }else{
                $data[$i] = [
                    'date' => $inputs[$i]['hidden_date'],                
                    '01_staff' => isset($inputs[$i]['staff'][0]) ? $inputs[$i]['staff'][0] : null,
                    '02_staff' => isset($inputs[$i]['staff'][1]) ? $inputs[$i]['staff'][1] : null,
                    '03_staff' => isset($inputs[$i]['staff'][2]) ? $inputs[$i]['staff'][2] : null,
                    '04_staff' => isset($inputs[$i]['staff'][3]) ? $inputs[$i]['staff'][3] : null,
                    '05_staff' => isset($inputs[$i]['staff'][4]) ? $inputs[$i]['staff'][4] : null,                
                    'event' => $inputs[$i]['event']
                ];
            }
        }
        self::updateOrCreate($data);
        // foreach($inputs as $input){
        //     $shift = new Shift;
        //     $shift->date = $input['hidden_date'];
        //     $shift->"01_staff" = isset($input['staff'][0]) ? $input['staff'][0] : null;
        //     $shift->02_staff = isset($input['staff'][1]) ? $input['staff'][1] : null;
        //     $shift->03_staff = isset($input['staff'][2]) ? $input['staff'][2] : null;
        //     $shift->04_staff = isset($input['staff'][3]) ? $input['staff'][3] : null;
        //     $shift->05_staff = isset($input['staff'][4]) ? $input['staff'][4] : null;
        //     $shift->event = $input['event'];
        //     $shift->save();
        // }
        echo 'success!';
        // dd($data);
        exit;  
    }

}
