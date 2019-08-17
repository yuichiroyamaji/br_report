
@extends('layouts.common')

@inject('dayservice', 'App\Services\DayService')

@section('title', 'シフト登録内容確認')
@section('local_css')
	<link rel="stylesheet" href="{{ url('assets/back/shift/confirm.css') }}" />
@endsection
@section('local_js')
	<script type="text/javascript">
	</script>
@endsection
@section('content')
	<nav>
		<p class="float left discription">※以下の内容で登録します</p>
		<button type="button" class="float right" onclick="location.href='{!! route('back.shift.store') !!}'">確定</button>
		<button type="button" class="float right" onclick="history.back()">戻る</button>
	</nav>
	<main>
		<div id="wrapper">
			<section>
				<div class="section_title">{{ $year }} 年 {{ $month }} 月度シフト表</div>
				<div class="contents">
				@foreach($shifts as $shift)
					{{$shift['date']}}
					@isset($shift['str_staff']){{$shift['str_staff']}}@endisset
					@isset($shift['event']) 【{{$shift['event']}}】@endisset 
					<br>
				@endforeach
				</div>
			</section>
		</div>
	</main>
@endsection
