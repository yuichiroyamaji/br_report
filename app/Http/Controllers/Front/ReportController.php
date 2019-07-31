<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Log;
use Carbon\Carbon;
use App\Services\DayService;
use App\Services\EmailSendService;
use App\Report;
use App\User;
use App\Items\Constances;

class ReportController extends Controller
{
    public function index(){
        $staffs = User::getExceptSysAdmin();
        $option_staffs = self::optionize($staffs);
        $expense_types = Constances::EXPENSE_TYPE;
        $option_expense_types = self::optionize($expense_types);
    	return view('contents.front.report.index')->with([
            'dates' => DayService::separeteDate(Carbon::now()->subHour(16)),
            'staffs' => $option_staffs,
            'expense_types' => $option_expense_types
        ]);
    }

    private function optionize($arrays){
        $options = '';
        foreach($arrays as $array){
            $options .= '<option>'.$array.'</option>';
        }
        return $options;
    }

    public function back(){
        redirect('front.report');
    }

    public function send(Request $request){  
        DB::beginTransaction();
        try{
            //POSTコレクションデータの配列化
            $input = $request->all();
            $post_date = ['year'=>$input['year'], 'month'=>$input['month'], 'date'=>$input['_date']];
            //計算処理
            $input['date'] = $input['year'].'-'.$input['month'].'-'.$input['_date'];
            $input['net_credit_sales'] = $input['credit_sales'] * Constances::CREDIT_COEFFICIENT;
            $input['net_sales'] = $input['remained_cash'] + $input['net_credit_sales'];
            if($input['01_expense_pay'] == null){$input['01_expense'] = null;}
            //過去データ確認・削除（経費のみの場合は日報ではないので削除しない）
            if(empty($input['expense_flg'])){
                Report::deletePastReport($input['date']);
                $report_type = '売上';
            }else{                
                $input['expense_flg'] = true;
                $report_type = '経費';
            }
            $mail_msg = $input;
            //カラム名取得
            $columns = Report::columns();
            //insert用データ作成
            foreach($columns as $col){
                if(empty($input[$col->{'COLUMN_NAME'}])){
                    if($col->{'DATA_TYPE'} == 'tinyint'){
                        $input[$col->{'COLUMN_NAME'}] = 0;
                    }else{
                        $input[$col->{'COLUMN_NAME'}] = null;
                    }
                }
            }
            //テーブル構造(カラム)に存在しないpostのパラメーターをカット
            array_splice($input, 0, 4);
            array_splice($mail_msg, 0, 4);
            //レポートの登録insert処理
            Report::insertReport($input);
            $results = Report::getThisMonthRecord($post_date['year'], $post_date['month']);
            //変数の宣言
            $total_sales = 0; $net_sales = 0; $credit_sales = 0; $total_labor_cost = 0; $total_expense_cost = 0;
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
        $msg = '';
        $msg_html = '';
        foreach($mail_msg as $key => $value){
            foreach($columns as $col){
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
        $days = DayService::$days;
		$week = date("w",mktime(0,0,0,$post_date['month'],$post_date['date'],$post_date['year']));
        $dates = $post_date['year'].'年'.$post_date['month'].'月'.$post_date['date'].'日('.$days[$week].')';
        $to      = Constances::OWNER_EMAIL;
        $subject = '【'.$report_type.'報告】'.$dates;
        $message = '------------------------------'."\r\n";
        $message .= $post_date['year'].'年'.$post_date['month'].'月度実績'."\r\n";
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
        $send_mail = new EmailSendService;
        $send_mail->send($to, $subject, $message);
        return redirect('/report/complete')->withInput([
                                                    'dates' => $dates,
                                                    'msg' => $msg_html
                                                ]);
    }

    public function complete(Request $request){
        return view('contents.front.report.complete')->with([
                                                    'dates' => $request->old('dates'),
                                                    'msg' => $request->old('msg')
                                                ]);
    }
}
