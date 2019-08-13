<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Report;
use Carbon\Carbon;
use App\Services\DayService;
use App\User;
use Log;
use DB;

class Shift extends Model
{
    use SoftDeletes;
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
        'dayoff_flg'
    ];
    
    public static function getMonthShifts($date){
    	//User情報をDBから取得
    	$users = User::getAllUsers();
    	//対象月のシフト情報を取得
    	$shifts = self::whereYear('date', $date->year)->whereMonth('date', $date->month)->where('deleted_at', null)->get();
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

    public function validateStaffInput($shifts){


    }

    public function staffArrayToString($shifts){
        for($i=1; $i<=count($shifts); $i++){
            if(isset($shifts[$i]['staff'])){
                for($j=0; $j<=4; $j++){
                    if(isset($shifts[$i]['staff'][$j])){
                        // if($shifts[$i]['staff'][$j] === '0'){
                        //     $shifts[$i]['staff'][$j] = '休み';
                        // }else{
                            $shifts[$i]['staff'][$j] = User::getName($shifts[$i]['staff'][$j]);
                        // }
                    }
                }     
                $shifts[$i]['str_staff'] = implode(", ", $shifts[$i]['staff']);
            }else{
                $shifts[$i]['str_staff'] = '休み';
            }
        }
        return $shifts;
    }

    public static function updateOrInsert($input){
        // $count = count(array_except($input, ['date']));
        for($i=1; $i<=count($input); $i++){
            $data[$i]['date'] = $input[$i]['hidden_date'];
            if(isset($input[$i]['staff'][0]) && $input[$i]['staff'][0] == 0){
                $data[$i] += [      
                    '01_staff' => null,
                    '02_staff' => null,
                    '03_staff' => null,
                    '04_staff' => null,
                    '05_staff' => null,
                    'dayoff_flg' => true
                ];
            }else{
                $data[$i] += [      
                    '01_staff' => isset($input[$i]['staff'][0]) ? $input[$i]['staff'][0] : null,
                    '02_staff' => isset($input[$i]['staff'][1]) ? $input[$i]['staff'][1] : null,
                    '03_staff' => isset($input[$i]['staff'][2]) ? $input[$i]['staff'][2] : null,
                    '04_staff' => isset($input[$i]['staff'][3]) ? $input[$i]['staff'][3] : null,
                    '05_staff' => isset($input[$i]['staff'][4]) ? $input[$i]['staff'][4] : null,
                    'dayoff_flg' => false
                ];              
            }
            $data[$i]['event'] = $input[$i]['event'];
            self::updateOrCreate(['date' => $data[$i]['date']], $data[$i]);
        //     $data[$i]['created_at'] = Carbon::now();
        //     $data[$i]['updated_at'] = Carbon::now();
        }
        // self::whereMonth('date', $input['date']['month'])->delete();
        // self::insert($data);
        return true;
    }

}
