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

class ShiftController extends Controller
{
    public function index(){
    	// 20日以降の場合は翌月分のシフトを表示させるため月を繰り上げ。日付は今日の日にちではなく対象月の最終日を渡す
    	$today = Carbon::today()->day > 20 ? Carbon::today()->addMonth()->endOfMonth() : Carbon::today()->endOfMonth();
    	// 配列化
    	$dates = DayService::separeteDate($today);
        $staffs = User::getExceptSysAdminWithId()->toArray();
        $staffs = array_merge([0 => '休み'], $staffs);
        $table = Shift::getMonthShifts($today);
    	return view('contents.back.shift.index', compact('dates', 'staffs', 'table'));
    }

    public function switch(Request $request){
        echo 'switch';
        dd($request);
        exit;
    }

    public function update(Request $request){
        // dd($request);
        // exit;
        $input = $request->except('_token');
        Shift::updateOrCreate($input);
    }
}
