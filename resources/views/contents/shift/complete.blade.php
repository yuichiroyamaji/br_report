<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BR日報</title>
	<!--CSS -->
	<link rel="stylesheet" href="./css/bootstrap.min.css" />
	<!--自作CSS -->
	<link rel="stylesheet" href="./css/report_201808260856.css" />
	<!--JS -->
	<script src="./js/jquery.js"></script>
	<script src="./js/jquery.color.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<!--自作JS -->
    <!-- <script src="./js/report.js"></script> -->
    <style>
    	body{
    		padding: 2%;
    	}
    	section{
    		background-color: #eee;
    		/*padding: 2%;*/
    	}
    	#title{    		
			background-color: #999;
			color: #fff;
			padding: 5px;
    	}
    	#contents{
    		padding: 0 4%;
    	}
    	#message{
			background-color: #ffbf7f;
			color: #fff;
    		text-align: center;
    		padding: 2%;
    		border-radius: 5px;
    	}
    	span{
    		font-size: 1.5em;
    	}
    	#btn-area{
    		text-align: right;
    	}
    	button{
    		padding: 2%;
    	}
	</style>
</head>
<body>
	<section>
		@if($dates != null)	
			<p id="title"> {{$dates}} 売上げ報告</p>
			<div id="contents">
				<p id="message">
					以下の内容を【美咲】へ送信しました。<br><span class="em">今日もお疲れ様でした！</span>
				</p>
				<p id="post_body">
					@foreach($msg as $line)
						{{$line}}<br>
					@endforeach
				</p>
			</div>
		@else
			<p id="title"> ----年--月--日(-) 売上げ報告</p>
			<div id="contents">
				<p id="message"> 報告は完了しています。<br>報告ページへは「報告をやり直す」<br>ボタンから移動できます。</p>
				<br>
			</div>
		@endif		
	</section>
	<p id="btn-area">
		<button type="button" onclick="location.href='http://galfie.xsrv.jp/laravel/report'">報告をやり直す</button>
	</p>
</body>
</html>