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
            $param[$i]['dayoff'] = $target_shift->pluck('dayoff_flg')->first();
            $param[$i]['selected'] = NULL;
    		if($param[$i]['dayoff'] == 0 && $target_shift->isNotEmpty()){  
				for($h=1; $h<=5; $h++){
                    $col_nm = strval(sprintf('%02d', $h).'_staff');
					$staff_id = $target_shift->pluck($col_nm)->first();
					if(!$staff_id){break;}
					$param[$i]['selected'][] = $users->where('userid', $staff_id)->pluck('userid')->first();
				}
    		}
    		$param[$i]['event'] = $target_shift->pluck('event')->first();
    	}
    	return $param;
    }

    // 休みの設定日にシフトが登録されていないか確認関数-->「出勤」をoldデータから戻すのが面倒だから中止
    // public function validateStaffInput($shifts){
    //     for($i=1; $i<=count($shifts); $i++){
    //         if(isset($shifts[$i]['dayoff'])){
    //             if(isset($shifts[$i]['staff']) || isset($shifts[$i]['event'])){return $i;}else{continue;}
    //         }
    //     }
    //     return true;
    // }

    public static function staffArrayToString($shifts){
        for($i=1; $i<=count($shifts); $i++){
            if(isset($shifts[$i]['dayoff'])){
                $shifts[$i]['str_staff'] = '休み';                
            }else{
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
                    $shifts[$i]['str_staff'] = '';
                }
            }
        }
        return $shifts;
    }

    public static function updateOrInsert($input){
        DB::beginTransaction();
        try{
            for($i=1; $i<=count($input); $i++){
                $data[$i]['date'] = $input[$i]['hidden_date'];
                if(isset($input[$i]['dayoff']) && $input[$i]['dayoff'] == true){
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
                $data[$i]['event'] = isset($input[$i]['event']) ? $input[$i]['event'] : null;
                self::updateOrCreate(['date' => $data[$i]['date']], $data[$i]);
            //     $data[$i]['created_at'] = Carbon::now();
            //     $data[$i]['updated_at'] = Carbon::now();
            }
            // self::whereMonth('date', $input['date']['month'])->delete();
            // self::insert($data);            
            DB::commit();
            return true;
        }catch(Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }

}
