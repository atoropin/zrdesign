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
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?hash={{ rand(0, 10) }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/4.13.0/bodymovin.js"></script><!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
                <a class="logo" href=""><img class="logo-image" src="{{ asset('img/logo.png') }}"/></a>
            </div>
            <div class="header-brand-menu">
                <ul>
                    @foreach ($brandData as $brand)
                        <li>
                            <a href="#"><img class="menu-img" src="{{ asset('img/brands/'.$brand->logo_file_name) }}"/></a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </header>
    <div class="menu-hz-content">
        <div class="menu-hz">
            @foreach ($brandData as $brand)
                <ul>
                    @foreach($brand->models as $model)
                        <li>{{ $model->name }}</li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>
    <div class="menu-hz-content">
        <div class="menu-hz">
            @foreach ($brandData as $brand)
                @foreach($brand->models as $model)
                    <ul>
                        @foreach($model->bodies as $body)
                            <li>{{ $body->name }}</li>
                        @endforeach
                    </ul>
                @endforeach
            @endforeach
        </div>
    </div>
    <div class="menu-sup-content">
        <div class="menu-sup">
            <ul class="manufacturers">
                @foreach($manufacturers as $manufacturer)
                    <li><a href="{{ route('products', array_merge($parameters, ['manufacturer' => $manufacturer->id])) }}">{{ $manufacturer->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="main-container">
        <div class="menu-left-content">
            @isset($carBodyInfo)
            <div class="menu-left-back">
                <a href="{{ route('products', ['body' => $carBodyInfo['id']]) }}">Полный список</a>
            </div>
            @endisset
            <div class="menu-left">
                <ul>
                    @foreach($groups as $group)
                        <li><a href="{{ route('products', array_merge($parameters, ['group' => $group->id])) }}">{{ $group->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        @isset($productsCarousel)
            <div class="content">
                @foreach($productsCarousel as $product)
                    <div class="content-product">
                        {{ $product->name }}
                        @foreach($product->pictures as $picture)
                            <img src="/img/{{ $picture->id . '/thumb/' . $picture->picture_file_name }}">
                        @endforeach
                    </div>
                    <div>
                        <a href='#' id="addToCartButton{{ $product->id }}" onclick="addToCart({{ $product->id }}); return false" style="color: yellow;">Добавить в корзину {{ $product->id }}</a>
                    </div>
                @endforeach
            </div>
        @endisset
        @isset($products)
            <div class="content">
                @foreach($products as $product)
                    <div class="content-product">
                        {{ $product->name }}
                        @foreach($product->pictures as $picture)
                            <img src="/img/{{ $picture->id . '/thumb/' . $picture->picture_file_name }}">
                        @endforeach
                    </div>
                    <div>
                        <a href='#' id="addToCartButton{{ $product->id }}" onclick="addToCart({{ $product->id }}); return false" style="color: yellow;">Добавить в корзину {{ $product->id }}</a>
                    </div>
                @endforeach
            </div>
        @endisset
    </div>

</div>

<script src="assets/js/jquery-3.3.1.slim.min.js"></script>
<!--script(src="assets/js/jquery.touchSwipe.min.js")-->
<script src="assets/js/scripts.js"></script>

<script>
    $('.manufacturers').mousemove(function(e){

        // Find the width of all menu elements
        var totalWidth = 0;
        $(this).find('li').each(function(i) {
            totalWidth += parseInt( $(this).outerWidth(), 10 );
        });

        // Find the cursor ratio and position the menu
        var l = (window.innerWidth - totalWidth) * e.pageX / (window.innerWidth-20);
        $(this).find('li').css('transform','translateX('+ l + 'px)');

    });
</script>

<script>
    function addToCart(product) {
        $.ajax({
            type: 'POST',
            url: '/cart/add/'+product,
            success: function() {
                $('#addToCartButton'+product).text('Товар добавлен в корзину')
                setTimeout(() => {
                    $('#addToCartButton'+product).text('Добавить в корзину')
            }, 2000)
            }
        })
        return false;
    }
</script>

<!--+Menu-->
</body></html>