<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function showReportPage(){
    	// DB::beginTransaction();
    	// try{
    	// 	$users = DB::table('users')->orderBy('id')->select('name')->get();
	    // 	DB::commit();
    	// }catch(Exception $e){
    	// 	DB::rollBack();
    	// 	Log::error($e->getMessage();)
    	// }
    	// DB::transaction(function(){
    	// 	$users = DB::table('users')->orderBy('id')->select('name')->get();
    	// 	return $users;
    	// });
        $days = Constances::$days;
        $year = date('Y' , strtotime('-18 hour'));
        $month = date('n' , strtotime('-18 hour'));
        $date = date('d' , strtotime('-18 hour'));
    	$dates = [
    		'year' => $year,
    		'month' => $month,
    		'date' => $date,
            'day' => $days[date('w')]
    	];
    	// $users = DB::table('users')->orderBy('id')->select('name')->get();
    	// $expenses = [
    	// 	'酒屋',
    	// 	'おしぼり',
    	// 	'NAC',
    	// 	'代引き',
    	// 	'雑費'
    	// ];
    	return view('contents.report.report')->with([
    		'dates' => $dates
    		// 'users' => $users,
    		// 'expenses' => $expenses
    	]);
    }

    public function showConfirmPage(Request $request){

    }

    public function registerRequest(Request $request){  
        //バリデーション✓ 
        // $request->validate([
        //     'cash_sales' => 'required',
        // ]);        
        DB::beginTransaction();
        try{
            //POSTコレクションデータの配列化
            $input = $request->all();
            //月トータルの計算に使う変数定義
            $year = $input['year'];
            $month = $input['month'];
            $date = $input['_date'];
            //計算処理
            $input['date'] = $input['year'].'-'.$input['month'].'-'.$input['_date'];
            $input['net_credit_sales'] = $input['credit_sales'] * 0.9;
            $input['net_sales'] = $input['remained_cash'] + $input['net_credit_sales'];
            if($input['01_expense_pay'] == null){$input['01_expense'] = null;}
            //過去データ確認・削除（経費のみの場合は日報ではないので削除しない）
            if(empty($input['expense_flg'])){
                $existence = DB::table('reports')->where('date', $input['date'])->where('expense_flg', '<>', 1)->get();
                if($existence){
                    DB::table('reports')->where('date', $input['date'])->where('expense_flg', '<>', 1)->update(['delete_flg' => 1, 'deleted_at' => Carbon::now()]);
                }
                $report_type = '売上';
            }else{                
                $input['expense_flg'] = true;
                $report_type = '経費';
            }
            // unset($input['expense_flg']);
            $mail_msg = $input;
            //カラム名取得
            $column = DB::table('information_schema.columns')->where('TABLE_NAME', 'reports')->get();
            //insert用データ作成
            foreach($column as $col){
                if(empty($input[$col->{'COLUMN_NAME'}])){
                    if($col->{'COLUMN_NAME'} == 'created_at' or $col->{'COLUMN_NAME'} == 'updated_at'){
                        $input[$col->{'COLUMN_NAME'}] = Carbon::now();
                    }else if($col->{'DATA_TYPE'} == 'tinyint'){
                        $input[$col->{'COLUMN_NAME'}] = 0;
                    }else{
                        $input[$col->{'COLUMN_NAME'}] = null;
                    }
                }
            }
            array_splice($input, 0, 4);
            array_splice($mail_msg, 0, 4);
            //insert処理
            DB::table('reports')->insert($input);
            // $results = DB::table('reports')->select('total_sales', 'net_sales')->whereYear('date', $year)->whereMonth('date', $month)->where('delete_flg', 0)->get();
            $results = DB::table('reports')->whereYear('date', $year)->whereMonth('date', $month)->where('delete_flg', 0)->get();
            $total_sales = 0;
            $net_sales = 0;
            $credit_sales = 0;
            $total_labor_cost = 0;
            $total_expense_cost = 0;
            foreach($results as $result){
                $total_sales = intval($total_sales) + intval($result->total_sales);
                $net_sales = intval($net_sales) + intval($result->net_sales);
                $credit_sales = intval($credit_sales) + intval($result->credit_sales);
                for($i=1; $i<=5; $i++){
                    $staff_pay = '0'.$i.'_total_pay';
                    if($result->$staff_pay == null){break;}
                    $total_labor_cost = intval($total_labor_cost) + intval($result->$staff_pay);
                }
                for($i=1; $i<=5; $i++){
                    $expense_pay = '0'.$i.'_expense_pay';
                    if($result->$expense_pay == null){break;}
                    $total_expense_cost = intval($total_expense_cost) + intval($result->$expense_pay);
                }
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
        }
        //メールの送信
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        $msg = '';
        $msg_html = '';
        foreach($mail_msg as $key => $value){
            foreach($column as $col){
                if($key == $col->{'COLUMN_NAME'}){
                    if($value != null){
                        $msg .= '['.$col->{'COLUMN_COMMENT'}.'] '.$value."\r\n";
                        $msg_html .= '['.$col->{'COLUMN_COMMENT'}.'] '.$value.",";
                    }
                    $skip = true;
                    break;
                }
            }
            if($skip){continue;}    
            $msg .= '['.$key.'] '.$value."\r\n";
            $msg_html .= '['.$key.'] '.$value.",";
        }
        $msg_html = explode(',', $msg_html);
        $days = Constances::$days;
		$week = date("w",mktime(0,0,0,$month,$date,$year));
        $dates = $year.'年'.$month.'月'.$date.'日('.$days[$week].')';

        $to      = 'Y.071081010622@icloud.com';
        // $to      = 'yuichiroyamaji@hotmail.com';
        $subject = '【'.$report_type.'報告】'.$dates;
        // $message = '('.Carbon::now().'時点)'."\r\n";
        $message = '------------------------------'."\r\n";
        $message .= $year.'年'.$month.'月度実績'."\r\n";
        $message .= '------------------------------'."\r\n";
        $message .= '総売上げ額： '.$total_sales.'円'."\r\n";
        $message .= '総純利益額： '.$net_sales.'円'."\r\n";
        $message .= '(総カード売上： '.$credit_sales.'円)'."\r\n";
        $message .= '(総人件費： '.$total_labor_cost.'円)'."\r\n";
        $message .= '(総経費： '.$total_expense_cost.'円)'."\r\n";
        $message .= "\r\n";
        $message .= '------------------------------'."\r\n";
        $message .= $report_type.'報告内容'."\r\n";
        $message .= '------------------------------'."\r\n";
        $message .= $msg."\r\n";
        $headers = 'From: no-reply@br.com'."\r\n";
        $headers .= 'Bcc: yuichiroyamaji@hotmail.com'."\r\n";
        mb_send_mail($to, $subject, $message, $headers);

        //完了画面へ
        // return redirect('/report/complete');
        // return view('contents.report.complete')->with([
        //                                             'dates' => $dates,
        //                                             'msg' => $msg_html
        //                                         ]);
        return redirect('/report/complete')->withInput([
                                                    'dates' => $dates,
                                                    'msg' => $msg_html
                                                ]);
    }

    public function showCompletePage(Request $request){
        // $day = ['日', '月', '火', '水', '木', '金', '土'];
        // $dates = [
        //     'year' => date('Y'),
        //     'month' => date('n'),
        //     'date' => date('d'),
        //     'day' => $day[date('w')]
        // ];
        return view('contents.report.complete')->with([
                                                    'dates' => $request->old('dates'),
                                                    'msg' => $request->old('msg')
                                                ]);
    }
}
