<!--END-->
<!--END--><!DOCTYPE html><!--[if IE 7]>
<html class="ie7" lang="ru">
<![endif]-->
<!--[if IE 8]>
<html class="ie8" lang="ru">
<![endif]-->
<!--[if IE 9]>
<html class="ie9" lang="ru">
<![endif]-->
<!--[if gt IE 9]><!--> <html lang="ru"> <!--<![endif]-->
<head>
    <title></title>
    <meta name="description" content="ZR Design">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link href="favicon.ico" rel="shortcut icon">
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}?hash={{ rand(0, 10) }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/4.13.0/bodymovin.js"></script><!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
<!--if lt IE 8
p.error-browser
    | Ваш браузер&nbsp;
    em устарел!&nbsp;
    a(href="http://browsehappy.com/") Выберите новую версию
        +s
        | браузера здесь&nbsp;
    | для правильного отображения сайта.
-->

<div class="site-container">
    <header class="header">
        <div class="header-content">
            <div class="header-logo">
                <a class="logo" href=""><img class="logo-image" src="{!! asset('img/logo.png') !!}"/></a>
            </div>
            <div class="header-brand-menu">
                <ul>
                    <li>
                        <a href=""><img class="menu-img" src="{!! asset('img/brands/audi.png') !!}"/></a>
                    </li>
                    <li>
                        <a href=""><img class="menu-img" src="{!! asset('img/brands/bmw.png') !!}"/></a>
                    </li>
                    <li>
                        <a href=""><img class="menu-img" src="{!! asset('img/brands/landrover.png') !!}"/></a>
                    </li>
                    <li>
                        <a href=""><img class="menu-img" src="{!! asset('img/brands/mercedes.png') !!}"/></a>
                    </li>
                    <li>
                        <a href=""><img class="menu-img" src="{!! asset('img/brands/porsche.png') !!}"/></a>
                    </li>
                    <li>
                        <a href=""><img class="menu-img" src="{!! asset('img/brands/volkswagen.png') !!}"/></a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="menu-hz-content">
        <div class="menu-hz">
            <ul>
                <li>1 series</li>
                <li>2 series</li>
                <li>3 series</li>
                <li>5 series</li>
                <li>7 series</li>
                <li>8 series</li>
            </ul>
        </div>
    </div>
    <div class="menu-hz-content">
        <div class="menu-hz">
            <ul>
                <li>E36</li>
                <li>E46</li>
                <li>E90</li>
                <li>E92</li>
                <li>F20</li>
            </ul>
        </div>
    </div>
    <div class="menu-sup-content">
        <div class="menu-sup">
            <ul>
                @foreach($manufacturers as $manufacturer)
                    <li><a href="{{ route('body', array_merge($parameters, ['manufacturer' => $manufacturer->id])) }}">{{ $manufacturer->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="main-container">
        <div class="menu-left-content">
            <div class="menu-left">
                <ul>
                    @foreach($groups as $group)
                        <li>{{ $group->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="content">
            {{--@foreach($products as $product)--}}
                {{--<div>--}}
                    {{--{{ $product->id }}--}}
                {{--</div>--}}
            {{--@endforeach--}}
        </div>
    </div>

</div>

<script src="assets/js/jquery-3.3.1.slim.min.js"></script>
<!--script(src="assets/js/jquery.touchSwipe.min.js")-->
<script src="assets/js/scripts.js"></script>
<!--+Menu-->
</body></html>