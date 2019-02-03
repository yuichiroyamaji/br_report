<!DOCTYPE html>
<html dir="ltr" class="no-js" lang="ja" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="utf-8" />
<title>Experiment</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<style>
</style>
<script>
	$(function(){		
		$('.count').change(function(){
			//total_sales calculation
			var total = 0;
			$('.plus').each(function(){
				var val = parseInt($(this).val());
				total = total + val;
			});
			$('.minus').each(function(){
				var val = parseInt($(this).val());
				total = total - val;
			});
			$('.total_sales').val(total);
			//remained_cash calculation
			var card_sales = parseInt($('.card_sales').val()),
				remained_cash = total - card_sales;
			$('.remained_cash').val(remained_cash);
		});
	});
</script>
</head>
<body>
	<div>remained_cash<input class="remained_cash" type="number" value="" readonly="readonly" style="background-color: #eee;"></div>
	<div>total_sales<input class="total_sales" type="number" value="" readonly="readonly" style="background-color: #eee;"></div>
	<div>card_sales<input class="card_sales count plus" type="number" value="0"></div>
	<div>bottle_sales<input class="bottle_sales count plus" type="number" value="0"></div>
	<div>01_staff<input class="01_staff count minus" type="number" value="0"></div>
	<div>02_staff<input class="02_staff count minus" type="number" value="0"></div>
	<div>03_staff<input class="03_staff count minus" type="number" value="0"></div>
	<div>01_expense<input class="01_expense count minus" type="number" value="0"></div>
	<div>02_expense<input class="02_expense count minus" type="number" value="0"></div>
	<div>03_expense<input class="03_expense count minus" type="number" value="0"></div>
</body>
</html>
