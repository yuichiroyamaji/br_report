
@extends('layouts.common')

@inject('dayservice', 'App\Services\DayService')

@section('title', 'シフト登録')
@section('local_css')
	<link rel="stylesheet" href="{{ url('assets/back/shift/index.css') }}" />
@endsection
@section('local_js')
	<script src="{{ url('assets/back/shift/index.js') }}"></script>
	<script type="text/javascript"></script>
@endsection
@section('content')
	{{ Form::open(['route' => 'back.shift.confirm', 'id' => 'store', 'name' => 'store']) }}{{Form::close()}}
	<nav>
		<input type="submit" value="シフト送信" class="float right" form="store">
		<p id="shift_title" class="float right">
			(
			{{ $dates['year'] }} 年 
			{{ $dates['month'] }} 月度
			)
		</p>
	</nav>
	<main>
		<div id="wrapper">
			<section>
				<!-- エラー処理出そうと思ったけどやめた -->
				<!-- <ul>
	                @foreach($errors->all() as $error)
	                    <li>{{ $error }}</li>
	                @endforeach
	                @if($errors->any())
					<h4>{{$errors->first()}}</h4>
					@endif
	            </ul> -->
				<div class="section_title">
					{{Form::open(['method' => 'get', 'route' => 'back.shift', 'id' => 'switch', 'name' => 'switch'])}}{{Form::close()}}
					{!! Form::select('year', $dayservice->years, $dates['year'], ['form' => 'switch']) !!} 年 {!! Form::select('month', $dayservice->months, $dates['month'], ['class' => 'resize ', 'id' => '01_resize', 'form' => 'switch']) !!} 月
					<input type="submit" value="表示切替" id="switch" form="switch" class="float right">
					
				</div>
					<table class='table table-bordered table-responsive'>
						{{ Form::hidden('year', $dates['year'], ['form' => 'store']) }}
						{{ Form::hidden('month', $dates['month'], ['form' => 'store']) }}
						<tr><th>日付</th><th>休み</th><th>出勤</th><th>イベント</th></tr>
						@for($i = 1; $i <= $dates['date']; $i++)
						<tr>
							<td>
								{{$table[$i]['date']}}
								{{ Form::hidden($i.'[date]', $table[$i]['date'], ['form' => 'store']) }}
								{{ Form::hidden($i.'[hidden_date]', $table[$i]['hidden_date'], ['form' => 'store']) }}
							</td>
							<td class='chckbx'>{{Form::checkbox($i.'[dayoff]', 1, $table[$i]['dayoff'], ['form' => 'store', 'class' => 'dayoff', 'align' => 'center', 'valign' => 'center'])}}</td>
							<td class="form-group {{ $errors->has('staff') ? ' has-error' : '' }}">
								{!! Form::select($i.'[staff][]', $staffs, $table[$i]['selected'], ['class' => 'form-control js-multiple target', 'multiple' => 'multiple', 'form' => 'store']) !!}
							</td>
							<td class="form-group {{ $errors->has('staff') ? ' has-error' : '' }}">
								{{ Form::text($i.'[event]', $table[$i]['event'], ['class' => 'target', 'form' => 'store', 'size' => '8']) }}
							</td>
						</tr>
						@endfor
					</table>
			</section>
		</div>	
	</main>
	
</div>
@endsection
