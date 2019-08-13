
@extends('layouts.common')

@inject('dayservice', 'App\Services\DayService')

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
          // $('form[name=update]').submit(function(){if(!confirm('この内容で登録･更新します。よろしいですか？')){return false;}});
          $(document).on('change', 'input[name=dayoff]', function(){
          	if(state = $(this).prop("checked")){
          		// $(this).parent().siblings().find('.select2-selection__rendered').children().remove();
          		$(this).parent().siblings().find('.select2-selection__choice__remove').each(function(){$(this).click();});
          		$(this).parent().siblings().find('.target').prop("disabled", true);
          	}else{
          		$(this).parent().siblings().find('.target').prop("disabled", false);
          	}
          	
          	// alert(state);
          });
      	});
	</script>
@endsection
@section('content')
	{{Form::open(['url' => '/admin/shift/confirm', 'id' => 'update', 'name' => 'update'])}}{{Form::close()}}
	<nav>
		<input type="submit" value="シフト送信" class="float right" form="update">
		<p id="shift_title" class="float right">
			(
			{{ $dates['year'] }} 年 
			{{ $dates['month'] }} 月度
			)
		</p>
	</nav>
	<main>
		<section>
			<div class="section_title">
				{{Form::open(['url' => '/admin/shift/switch', 'id' => 'switch', 'name' => 'switch'])}}{{Form::close()}}
				{!! Form::select('year', $dayservice->years, $dates['year'], ['form' => 'switch']) !!} 年 {!! Form::select('month', $dayservice->months, $dates['month'], ['class' => 'resize ', 'id' => '01_resize', 'form' => 'switch']) !!} 月度シフト
				<input type="submit" value="表示切替" id="switch" form="switch" class="float right">
				
			</div>
				<table class='table table-bordered table-responsive'>
					{{ Form::hidden('year', $dates['year'], ['form' => 'update']) }}
					{{ Form::hidden('month', $dates['month'], ['form' => 'update']) }}
					<tr><th>日付</th><th>休み</th><th>出勤</th><th>イベント</th></tr>
					@for($i = 1; $i <= $dates['date']; $i++)
					<tr>
						<td>
							{{$table[$i]['date']}}
							{{ Form::hidden($i.'[date]', $table[$i]['date'], ['form' => 'update']) }}
							{{ Form::hidden($i.'[hidden_date]', $table[$i]['hidden_date'], ['form' => 'update']) }}
						</td>
						<td class='hello'>{{Form::checkbox('dayoff', null, false)}}</td>
						<td class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
							{!! Form::select($i.'[staff][]', $staffs, $table[$i]['selected'], ['class' => 'form-control js-multiple target', 'multiple' => 'multiple', 'form' => 'update']) !!}
						</td>
						<td>{{ Form::text($i.'[event]', $table[$i]['event'], ['class' => 'target', 'form' => 'update']) }}</td>
					</tr>
					@endfor
				</table>
		</section>		
	</main>
	
</div>
@endsection
