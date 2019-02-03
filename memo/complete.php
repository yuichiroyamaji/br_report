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
    		padding: 2%;
    	}
    	#title{    		
			background-color: #ffbf7f;
			color: #fff;
			/*width: 90%;*/
			border-radius: 10px;
			margin: 10px 0;
			padding: 5px;
    	}
    	#contents{
    		text-align: center;
    	}
    	span{
    		font-size: 1.5em;
    	}
    	#btn-area{
    		text-align: right;
    	}
	</style>
</head>
<body>
	<section>
		<p id="title">2018/8/26(日) 売上げ報告</p>
		<p id="contents">
			<span>送信が完了しました！<br>今日もお疲れ様でした！</span>
		</p>		
	</section>
	<p id="btn-area">
		<button type="button" onclick="location.href='http://192.168.33.10/laravel/public/report'">報告をやり直す</button>
	</p>
</body>
</html>