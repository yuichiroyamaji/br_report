
@extends('layouts.common')

@inject('dayservice', 'App\Services\DayService')

@section('title', 'シフト設定')
@section('local_css')
	<link rel="stylesheet" href="{{ url('assets/back/common/css/common.css') }}" />
	<link rel="stylesheet" href="{{ url('assets/back/shift/shift.css') }}" />
@endsection
@section('local_js')
	<script type="text/javascript">
		
	</script>
@endsection
@section('content')
	<div id="wrapper">
		<div id="title">{{ $year }} 年 {{ $month }} 月度シフト表</div>
		<div id="contents">
		@foreach($shifts as $shift)
			{{$shift['date']}}
			@isset($shift['str_staff']){{$shift['str_staff']}}@endisset
			@isset($shift['event'])【{{$shift['event']}}】@endisset 
			<br>
		@endforeach
		</div>
	</div>
@endsection
