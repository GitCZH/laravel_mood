<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
<!-- Scripts -->
<div id="app">

    <div id="nav">
        <menu_header></menu_header>
    </div>
    <div id="content_main" style="min-height: 800px">
        @yield('content')
    </div>
    <hr>
    <div id="footer" class="container">
        <div class="row">
            <div class="col-md-4">
                <p>我的小站</p>
            </div>
            <div class="col-md-4">
                <p><a target="_blank"  href="https://beian.miit.gov.cn">皖ICP备17026760号-1</a></p>
            </div>
            <div class="col-md-4">
                <p>Copyright@CZH</p>
            </div>
        </div>
    </div>
</div>
<script src="/js/app.js"></script>
</body>
</html>