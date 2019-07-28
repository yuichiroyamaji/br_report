<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@yield('meta')
	<title>@yield('title')</title>
	<!--CSS -->
	<link rel="stylesheet" href="{{ url('assets/common/css/bootstrap.min.css') }}" />
	<link href="{{ url('assets/back/css/select2/select2.min.css') }}" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{{ url('assets/common/css/common.css') }}" />
	<!--自作CSS -->
	@yield('css')
	<!--JS -->
	<script src="{{ url('assets/common/js/jquery.js') }}"></script>
	<script src="{{ url('assets/common/js/jquery.color.js') }}"></script>
	<script src="{{ url('assets/common/js/bootstrap.min.js') }}"></script>
	<script src="{{ url('assets/back/js/select2/select2.min.js') }}"></script>
	<script src="{{ url('assets/back/js/select2/ja.js') }}"></script>
	<!--自作JS -->
    @yield('js')
</head>
<body>
	@yield('content')
</body>
</html>
