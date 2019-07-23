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
	<link rel="stylesheet" href="./css/report_201809251831.css" />
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
			<select id="width_tmp_select">
				<option id="width_tmp_option"></option>
			</select>
		</p>
		<input type="submit" value="表示切替">
		<!-- <p class="float right"><span class="text-danger">残金：</span><span class="remained_cash count" data-num="100">0</span><span class="text-danger">&nbsp円</span></p> -->
		<input type="hidden" name="date" value="">
		<input type="hidden" name="remained_cash">
	</nav>
	<div class="container">
	<main>
		<section>
			<div class="section_title">{{$dates['year']}} 年 {{$dates['month']}} 月度シフト</div>
			<div class="inner_section">
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
