<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BR日報</title>
	<!--CSS -->
	<link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
	<!--自作CSS -->
	<link rel="stylesheet" href="./assets/css/report.css" />
	<!--JS -->
	<script src="https://ajax.googleapis.com/ajax/dtbs/jquery/1.11.1/jquery.min.js"></script>
	<script src="./assets/js/bootstrap.min.js"></script>
	<!--自作JS -->
	<script src="report.js"></script>
</head>
<body>
	<div class="container">
	<nav></nav>
	<main>
		<!-- <div id="title">{{$dates['year'] }}年{{$dates['month']}}月{{$dates['date']}}日 売上報告</div> -->
		<form method="POST" action="/report/process">
			<div class="total_sales">今日の売り上げ総額
				<input type="number" class="money" name="total_sales">&nbsp円
			</div>
			<table class="table table-bordered" cellpadding="0" cellspacing="0">
				<caption><内訳></caption>
				<tr>
					<th class="align-middle" scope="row" colspan="3">【クレジット売上】</th>
					<td>合計<br><input type="number" class="money" name="credit_sales" step="10">&nbsp円</td>
				</tr>
				<tr>
					<th scope="row" colspan="3">【ボトル売上】</th>
					<td>合計<br><input type="number" class="money" name="bottle_sales" step="10">&nbsp円</td>
				</tr>
				<tr>
					<th scope="row" colspan="3">【スタッフ給与】</th>
					<td>合計<br><input type="number" class="money" name="total_staff_pay" readonly="readonly" style="background-color:#eee">&nbsp円</td>
				</tr>
				<tr>
					<td></td>
					<td colspan="2">ノーゲストの<br>場合はチェック</td>
					<td><input type="checkbox" name="no_guest_flg"></td>
				</tr>
				<tr>
					<td></td>
					<td colspan="2">
						スタッフ_01：<br>
						<select name="01_staff">
						<!-- @foreach($users as $user)
							<option>{{ $user->name }}</option>
						@endforeach -->
						</select>
					</td>
					<td>
						小計<br><input name="01_total_pay" class="money readonly" readonly="readonly" style="background-color:#eee">&nbsp円
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>
						店内勤務時間：<br>
						<input type="number" class="time" name="01_reg_hours" step="0.5">&nbsp時間
					</td>
					<td>
						 x <span id="01_reg_hours_rate"></span>円/時間 = 
						<span id="01_reg_hours_pay"></span>
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>
						同伴勤務時間：<br>
						<input type="number" class="time" name="01_accom_hours" step="0.5">&nbsp時間 
					</td>
					<td>
						x 1600円/時間 = 
						<span id="01_accom_hours_pay"></span>
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>
						ﾄﾞﾘﾝｸﾊﾞｯｸ：<br>
						<input type="number" class="time" name="01_drink_no" step="1">&nbsp杯 
					</td>
					<td>
						x 500円/杯 = 
						<span id="01_drink_pay"></span>
					</td>
				</tr>
				<tr>
					<td></td>
					<td colspan="3"><button id="add_staff">スタッフを追加</button></td>
				</tr>
				<tr>
					<th scope="row" colspan="3">【経費】</th>
					<td>
						合計<br><input type="number" class="money" name="total_expense_pay" step="10" readonly="readonly" style="background-color:#eee">&nbsp円
					</td>
				</tr>
				<tr>
					<td></td>
					<td colspan="2">経費_01：<br>
						<select name="01_expense">
						<!-- @foreach($expenses as $expense)
							<option>{{ $expense }}</option>
						@endforeach -->
						</select>
					</td>
					<td>
						小計<br><input type="number" class="money" name="01_expense_pay" step="10">&nbsp円
					</td>
				</tr>
				<tr>
					<td></td>
					<td colspan="3" class="text-align-top">
						<!-- <p>詳細･メモ：</p><textarea name="01_expense_memo" rows="3" cols="50"></textarea> -->
					</td>
				</tr>
				<tr>
					<td></td>
					<td colspan="3"><button id="add_expense">経費を追加</button></td>
				</tr>
			</table>
			<table class="table-dark table-bordered" cellpadding="10" cellspacing="0"><tr><td>aaa</td><td>bbb</td><td>ccc</td></tr></table>	
		</form>
	</main>
	<aside></aside>
	<footer></footer>
</div>
</body>
</html>