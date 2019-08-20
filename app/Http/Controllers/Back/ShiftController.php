<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Log;
use Carbon\Carbon;
use App\Services\DayService;
use App\Services\EmailSendService;
use App\Shift;
use App\Report;
use App\User;
use App\Items\Constances;
// 今回は使わないが、Validation使う時は自作した「ShiftRequest」を使う
// use App\Http\Requests\ShiftRequest;

class ShiftController extends Controller
{
    public function index(Request $request){
        if(null == $request->year || null == $request->month){
            // 20日以降の場合は翌月分のシフトを表示させるため月を繰り上げ。日付は今日の日にちではなく対象月の最終日を渡す
            $date = Carbon::today()->day > 20 ? Carbon::today()->addMonth()->endOfMonth() : Carbon::today()->endOfMonth();
        }else{
            $target_month = new Carbon($request->year.'-'.sprintf('%02d', $request->month));
            $date = $target_month->endOfMonth();
        }
    	// 配列化
    	$dates = DayService::separeteDate($date);
        $staffs = User::getExceptSysAdminWithId()->toArray();
        $table = Shift::getMonthShifts($date);
    	return view('contents.back.shift.index', compact('dates', 'staffs', 'table'));
    }

    // 今回は使わないが、Validation使う時は自作した「ShiftRequest」を使う
    // public function confirm(ShiftRequest $request){
    public function confirm(Request $request){
        $request->flash();
        $year = $request->year;
        $month = $request->month;
        $shifts_array = $request->except('_token', 'year', 'month');
        // 休みの設定日にシフトが登録されていないか確認-->「出勤」をoldデータから戻すのが面倒だから中止
        // $validation = $shift->validateStaffInput($shifts_array);
        // if($validation !== true){return back()->withErrors($validation.'日：休みの日に登録があります');}
        // スタッフの配列を文字列に変換して確認画面へ渡す
        $shifts = Shift::staffArrayToString($shifts_array);
        return view('contents.back.shift.confirm', compact('year', 'month', 'shifts'));
    }

    public function store(Request $request){
        $req_old = $request->old();
        if(empty($req_old)){
            return redirect()->route('back.shift');
        }else{
            $year = $req_old['year'];
            $month = $req_old['month'];
            $shifts_array = array_except($req_old, ['_token', 'year', 'month']);
            Shift::updateOrInsert($shifts_array);
            $shifts = Shift::staffArrayToString($shifts_array);
            EmailSendService::shiftMsg($year, $month, $shifts);
            return view('contents.back.shift.complete', compact('year', 'month'));
        }
    }
}
