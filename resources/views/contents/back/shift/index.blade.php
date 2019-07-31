
@extends('layouts.common')
@section('title', 'シフト設定')
@section('local_css')
	<link rel="stylesheet" href="{{ url('assets/back/common/css/common.css') }}" />
	<link rel="stylesheet" href="{{ url('assets/back/shift/shift.css') }}" />
@endsection
@section('local_js')
	<script type="text/javascript">
		// laravelの変数をJSに渡す
		var staffs = @json($staffs);
		$(document).ready(function() {
          $(".js-multiple").select2({ width: 'resolve' });
      });
	</script>
@endsection
@section('content')
	@env('production')
	<form method="POST" action="/laravel/shift/send">
	@else
	<form method="POST" action="/shift/send">
	@endenv
	{{ csrf_field() }}
	<nav>
		<input type="submit" value="シフト送信" class="float right">
		<p id="shift_title" class="float right">
			(
			@inject('dayservice', 'App\Services\DayService')
			{{ $dates['year'] }} 年 
			{{ $dates['month'] }} 月度
			)
		</p>
	</nav>
	</form>
	@env('production')
	<form method="POST" action="/laravel/shift/send">
	@else
	<form method="POST" action="/shift/send">
	@endenv
	<div class="container">
	<main>
		<section>
			<div class="section_title">
				{!! Form::select('year', $dayservice->years, $dates['year']) !!} 年 {!! Form::select('month[]', $dayservice->months, $dates['month'], ['class' => 'resize ', 'id' => '01_resize']) !!} 月度シフト
				<input type="submit" value="表示切替" id="switch" class="float right">
			</div>
				<table class='table table-bordered table-responsive'>
					<tr><th>日付</th><th>出勤</th><th>イベント</th></tr>
					@for($i = 1; $i <= $dates['date']; $i++)
					<tr>
						<td>{{$table[$i]['date']}}</td>
						<td class="staffs form-group{{ $errors->has('category') ? ' has-error' : '' }}">
							{!! Form::select('staffs[]', $staffs, $table[$i]['selected'], ['class' => 'form-control js-multiple', 'multiple' => 'multiple']) !!}
						</td>
						<td><input type="text" value="{{$table[$i]['event']}}"></td>
					</tr>			
					@endfor
				</table>
		</section>		
	</main>
	</form>
</div>
@endsection
