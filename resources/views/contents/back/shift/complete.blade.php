@extends('layouts.common')

@inject('dayservice', 'App\Services\DayService')

@section('title', 'シフト登録完了')
@section('local_css')
	<link rel="stylesheet" href="{{ url('assets/back/shift/complete.css') }}" />
@endsection
@section('local_js')
	<script type="text/javascript">
	</script>
@endsection
@section('content')
	<section>	
		<p id="title"> {{$year}} 年 {{$month}} 月度 シフト登録</p>
		<div id="contents">
			<p id="message">
				<span class="em">シフト登録が完了しました！</span><br>
			</p>
			<span>※やり直す場合は下記ボタンを押して下さい</span>
		</div>
	</section>
	<p id="btn-area">
		<button type="button" onclick="location.href='{!! route('back.shift') !!}'">シフト登録をやり直す</button>
	</p>
@endsection