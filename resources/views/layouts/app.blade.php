<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="userId" content="{{ (auth()->check())? auth()->id() : '' }}">
    <title>@yield('title')</title>
    <!-- Favicons -->
	<link rel="shortcut icon" href="{{ asset('frontend/images/favicon.ico') }}">
	<link rel="apple-touch-icon" href="{{ asset('frontend/images/icon.png') }}">
	<!-- Google font (font-family: 'Roboto', sans-serif; Poppins ; Satisfy) -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,600i,700,700i,800" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('frontend/css/plugins.css') }}">
	<link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

	<!-- Cusom css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    @yield('style')
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
   <!-- Modernizer js -->
	<script src="{{ asset('frontend/js/vendor/modernizr-3.5.0.min.js') }}"></script>
</head>

<body>
    <!--[if lte IE 9]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
	<![endif]-->
    <div id="app">
        <div class="wrapper" id="wrapper">
                @include('partial.frontend.header')
                 @yield('content')
                @include('partial.frontend.footer')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
	<script src="{{ asset ('frontend/js/plugins.js') }}"></script>
	<script src="{{ asset ('frontend/js/active.js') }}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    @yield('script')
    <script>
        @if(\Illuminate\Support\Facades\Session::has('success'))
        notif({
            msg: "<b>Success:</b> {{ \Illuminate\Support\Facades\Session::get('success') }}",
            type: "success"
        });
        @endif
        @if(\Illuminate\Support\Facades\Session::has('error'))
        notif({
            type: "error",
            msg: "<b>Error: </b>{{ \Illuminate\Support\Facades\Session::get('error') }}.",
            position: "center",
        });
        @endif


    </script>
</body>

</html>




