<html>
<head>
    <meta charset="utf-8"/>
    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Coin Crafter - @hasSection('title')@yield('title')@endif</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="og:locale" property="og:locale" content="en_US"/>
    <meta name="og:type" property="og:type" content="website"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('Components.stylesheets')
</head>
<body>
    @hasSection('content')
        @yield('content')
    @endif
<div>
    <script src="@lang('strings.app_url')js/main.min.js"></script>
</div>
@include('Components.scripts')
</body>
</html>