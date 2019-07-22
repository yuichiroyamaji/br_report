<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;
use Carbon\Carbon;
use App\Services\DayService;
use App\Services\EmailSendService;
use App\Report;
use App\User;
use App\Items\Constances;

class ShiftController extends Controller
{
    public function index(){
    	return view('contents.shift.shift')->with([
            'dates' => DayService::separeteDate(Carbon::now()->subHour(16)),
            'staffs' => User::getExceptSysAdmin(),
            'expense_types' => Constances::EXPENSE_TYPE
        ]);
    }
}
