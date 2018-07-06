<!DOCTYPE html>
<html>
<head>
    <title>ZR-Design - @yield('title')</title>
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

<div class="main-container">

    @yield('navigation')

    @yield('manufacturers')

    @yield('groups')

    <div class="content-container">
        @yield('content')
    </div>

</div>

</body>
</html>