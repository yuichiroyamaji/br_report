@extends('layouts.front.common')
@section('title', 'シフト設定')
@section('css')
	<link rel="stylesheet" href="./css/report_201809251831.css" />
@endsection
@section('js')
    <script type="text/javascript">
    	// laravelの変数をJSに渡す
    	var staffs = @json($staffs);
    	var expense_types = @json($expense_types);
	</script>
    <script src="./js/report_201812272025.js"></script>
@endsection
@section('content')
	@env('production')
	<form method="POST" action="/laravel/report/send">
	@else
	<form method="POST" action="/report/send">
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
			</select>/
			<select name="month" id="01_resize" class="resize">
				@for($i = 1; $i <= 12; $i++)
					@if($i == $dates['month'])
						<option selected>{{$i}}</option>
					@else
						<option>{{$i}}</option>
					@endif
				@endfor
			</select>/
			<select name="_date" id="02_resize" class="resize">
				@for($i = 1; $i <= 31; $i++)
					@if($i == $dates['date'])
						<option selected>{{$i}}</option>
					@else
						<option>{{$i}}</option>
					@endif
				@endfor
			</select>
			<select id="width_tmp_select">
				<option id="width_tmp_option"></option>
			</select>
		</p>
		<input type="submit" value="日報送信">
		<p class="float right"><span class="text-danger">残金：</span><span class="remained_cash count" data-num="100">0</span><span class="text-danger">&nbsp円</span></p>
		<input type="hidden" name="date" value="">
		<input type="hidden" name="remained_cash">
	</nav>
	<div class="container">
	<main>
		<section>
			<div class="section_title">売上げ</div>
			<div class="inner_section">
				<p class="sm_sec_title">今日の売上げ総額</p>
					<p class="form_input">
						<span id="total_sales" class="total_sales" >0</span>&nbsp円
						<input type="hidden" name="total_sales" value="">
					</p>
				<p class="sm_sec_title">現金売上げ</p>
					<p class="form_input"><input type="number" class="money sales count plus cash_sales" name="cash_sales" value="">&nbsp円</p>
					<!-- <p class="form_input">[内：ボトル売上げ]&nbsp&nbsp<input type="number" class="money count plus bottle_sales" name="bottle_sales" step="10" value="">&nbsp円</p>			 -->
				<p class="sm_sec_title">クレジット売上げ</p>
					<p class="form_input"><input type="number" class="money sales" name="credit_sales" step="10" value="">&nbsp円</p>
			</div><!--inner_section-->
		</section>
		<section>
			<div class="section_title">スタッフ給与</div>
			<div class="inner_section">
				<p class="no_guest"><label class="align-middle" for="no_guest_flg">ノーゲストの場合はチェック</label><input class="no_guest_flg" type="checkbox" name="no_guest_flg" value="0"></p>
				<div class="01_staff_section">
					<div class="md_sec_title staff"><p class="float left">スタッフ_01</p>
						<p class="float right"><select class="select_height" name="01_staff">@php echo $staffs; @endphp</select></p>
					</div>
					<p class="sm_sec_title">総給与額</p>
						<p class="form_input">
							<span id="01_total_pay" class="total_pay">0</span>&nbsp円
							<input type="hidden" name="01_total_pay" class="count minus" value="">
						</p>
					<p class="sm_sec_title">通常勤務時間</p>
						<p class="form_input">
							<input type="number" class="time reg_hours" name="01_reg_hours" step="0.5" value="">&nbsp時間 x <span class="reg_hours_rate" required>1200</span>円/時間 = <span id="01_reg_hours_pay" class="01_staff_cnt subtotal">0</span>&nbsp円
						</p>
					<p class="sm_sec_title">同伴勤務時間</p>
						<p class="form_input">
							<input type="number" class="time accom_hours" name="01_accom_hours" step="0.5" value="">&nbsp時間 x <span class="accom_hours_rate">1600</span>円/時間 = <span id="01_accom_hours_pay" class="01_staff_cnt subtotal">0</span>&nbsp円
						</p>
					<p class="sm_sec_title">ドリンクバック</p>
						<p class="form_input">
							<input type="number" class="time drink_no" name="01_drink_no" step="1" value="">&nbsp杯 x <span class="drink_rate">500</span>円/杯 = <span id="01_drink_pay" class="01_staff_cnt subtotal">0</span>&nbsp円
						</p>
					<p class="sm_sec_title">ボトルバック</p>
						<p class="form_input">
							<input type="number" id="01_bottle_pay" class="money 01_staff_cnt bottle_pay val_form" name="01_bottle_pay" step="10" value="">&nbsp円
						</p>
					<p class="sm_sec_title">ボーナス</p>
						<p class="form_input">
							<input type="number" id="01_bonus_pay" class="money 01_staff_cnt bonus_pay val_form" name="01_bonus_pay" step="10" value="">&nbsp円
						</p>
					<p class="sm_sec_title">メモ</p>
						<p class="form_input">
							<textarea name="01_memo"></textarea>
						</p>
				</div>
				<div class="02_staff_section additional_section"></div>
				<div class="03_staff_section additional_section"></div>
				<div class="04_staff_section additional_section"></div>
				<div class="05_staff_section additional_section"></div>
				<div class="06_staff_section additional_section"></div>
				<div class="07_staff_section additional_section"></div>
				<div class="08_staff_section additional_section"></div>
				<div class="09_staff_section additional_section"></div>
				<button type="button" id="add_staff">スタッフを追加</button>
			</div>
		</section>
		<section>
			<div class="section_title">経費</div>
			<div class="inner_section">
				<p class="no_guest"><label class="align-middle" for="no_guest_flg">経費のみの場合はチェック</label><input class="no_guest_flg" type="checkbox" name="expense_flg"></p>
				<div class="01_expense_section">
					<div class="md_sec_title expense"><p class="float left">経費_01</p>
						<p class="float right"><select class="select_height" name="01_expense">@php echo $expense_types; @endphp</select></p>
					</div>
					<p class="sm_sec_title">支払い額</p>
						<p class="form_input"><input type="number" name="01_expense_pay" class="money count minus expense_pay" value="">&nbsp円</p>
					<p class="sm_sec_title">詳細･メモ</p>
						<p class="form_input"><textarea name="01_expense_memo"></textarea></p>
				</div>
				<div class="02_expense_section additional_section"></div>
				<div class="03_expense_section additional_section"></div>
				<div class="04_expense_section additional_section"></div>
				<div class="05_expense_section additional_section"></div>
				<button type="button" id="add_expense">経費を追加</button>
			</div>
		</section>
	</main>
	</form>
</div>
@endsection
