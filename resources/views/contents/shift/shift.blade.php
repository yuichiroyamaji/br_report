<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>シフト設定</title>
	<!--CSS -->
	<link rel="stylesheet" href="./css/bootstrap.min.css" />
	<!--自作CSS -->
	<link rel="stylesheet" href="./css/common.css" />
	<link rel="stylesheet" href="./css/shift.css" />
	<!--JS -->
	<script src="./js/jquery.js"></script>
	<script src="./js/jquery.color.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<!--自作JS -->
    <script type="text/javascript">
    	// laravelの変数をJSに渡す
    	var staffs = @json($staffs);
    	var expense_types = @json($expense_types);
	</script>
    <script src="./js/report_201812272025.js"></script>
</head>
<body>
	@env('production')
	<form method="POST" action="/laravel/shift/send">
	@else
	<form method="POST" action="/shift/send">
	@endenv
	{{ csrf_field() }}
	<nav>
		<p id="date" class="float left">
			<select name="year">
				@for($i = 2018; $i <= 2030; $i++)
					@if($i == $dates['year'])
						<option selected>{{$i}}</option>
					@else
						<option>{{$i}}</option>
					@endif
				@endfor
			</select> 年 
			<select name="month" id="01_resize" class="resize">
				@for($i = 1; $i <= 12; $i++)
					@if($i == $dates['month'])
						<option selected>{{$i}}</option>
					@else
						<option>{{$i}}</option>
					@endif
				@endfor
			</select> 月度
		</p>
		<input type="submit" value="表示切替">
	</nav>
	<div class="container">
	<main>
		<section>
			<div class="section_title">{{$dates['year']}} 年 {{$dates['month']}} 月度シフト</div>
			<div class="inner_section">
				<table class='table table-bordered table-responsive'>
					<tr><th>日付</th><th>出勤</th><th>イベント</th></tr>
					@for($i = 1; $i <= $dates['date']; $i++)
						<tr><td>{{$dates['year']}}/{{$dates['month']}}/{{$i}}</td><td></td><td><input type="text"></td></tr>
					@endfor
				</table>
				
				{!! Form::select('category', 'staffs', null, ['class' => 'form-control']) !!}
				<!-- <p class="sm_sec_title">今日の売上げ総額</p>
					<p class="form_input">
						<span id="total_sales" class="total_sales" >0</span>&nbsp円
						<input type="hidden" name="total_sales" value="">
					</p>
				<p class="sm_sec_title">現金売上げ</p>
					<p class="form_input"><input type="number" class="money sales count plus cash_sales" name="cash_sales" value="">&nbsp円</p>
				<p class="sm_sec_title">クレジット売上げ</p>
					<p class="form_input"><input type="number" class="money sales" name="credit_sales" step="10" value="">&nbsp円</p> -->
			</div>
		</section>		
	</main>
	</form>
</div>
</body>
</html>
