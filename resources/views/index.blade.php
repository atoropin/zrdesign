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
<!--[if gt IE 9]><!-->
<html lang="ru"> <!--<![endif]-->
<head>
    <title></title>
    <meta name="description" content="ZR Design">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link href="favicon.ico" rel="shortcut icon">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?hash={{ rand(0, 10) }}">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/4.13.0/bodymovin.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <!--[if lt IE 9]>
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

<script>
    function addToCart(product) {
        $.ajax({
            type: 'POST',
            url: '/cart/add/' + product,
            success: function () {
                $('#addToCartButton' + product).text('Товар добавлен в корзину')
                setTimeout(() => {
                    $('#addToCartButton' + product).text('Добавить в корзину')
                }, 1000)
            }
        })
        return false;
    }
</script>

<div class="site-container">
    <header class="header">
        <div class="header-content">
            <div class="header-logo">
                <a class="logo" href="/"><img class="logo-image" src="{{ asset('img/logo.png') }}"/></a>
            </div>
            <div class="header-brand-menu">
                <ul>
                    @foreach ($brandData as $brand)
                        <li>
                            <a href="#"><img onclick="showBrand(event, {{$brand->id}})" class="menu-img"
                                             src="{{ asset('img/brands/'.$brand->logo_file_name) }}"/></a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </header>
    <div class="menu-hz-content">
        <div class="menu-hz">
            @foreach ($brandData as $brand)
                <ul id="brand_{{$brand->id}}" class="brand__list">
                    @foreach($brand->models as $model)
                        <li onclick="showModel(event, {{$model->id}})">{{ $model->name }}</li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>
    <div class="menu-hz-content">
        <div class="menu-hz">
            @foreach ($brandData as $brand)
                @foreach($brand->models as $model)
                    <ul id="model_{{$model->id}}" class="model__list">
                        @foreach($model->bodies as $body)
                            @isset($parameters['body'])
                                @if($body->id == $parameters['body'])<li><b>{{ $body->name }}</b></li>
                                @else
                                <li><a href="{{ route('products', ['body' => $body->id]) }}">{{ $body->name }}</a></li>
                                @endif
                                @else
                                    <li><a href="{{ route('products', ['body' => $body->id]) }}">{{ $body->name }}</a></li>
                            @endisset
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
                    <li>
                        <a href="{{ route('products', array_merge($parameters, ['manufacturer' => $manufacturer->id])) }}">{{ mb_strtoupper($manufacturer->name) }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="main-container">
        <div class="menu-left-content">
            @isset($parameters['body'])
                <div class="menu-left-back">
                    <a href="{{ route('products', ['body' => $parameters['body']]) }}">Весь список для <b>{{ $body->name }}</b></a>
                </div>
            @endisset
            <div class="menu-left">
                <ul>
                    @foreach($groups as $group)
                        <li>
                            <a href="{{ route('products', array_merge($parameters, ['group' => $group->id])) }}">{{ $group->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @isset($productsCarousel)
            {{--<div class="carousel">--}}
            {{--<div class="content">--}}
                {{--@foreach($productsCarousel as $product)--}}
                    {{--<div class="content-product">--}}
                        {{--{{ $product->name }}--}}
                        {{--<div class="owl-carousel owl-theme">--}}
                            {{--@foreach($product->pictures as $picture)--}}
                            {{--<img src="/img/{{ $picture->id . '/thumb/' . $picture->picture_file_name }}">--}}
                                {{--<div class="item"><img src="{{ env('S3_SITE', 'https://s3-ap-southeast-1.amazonaws.com/zrdesigndb/production/product_pictures') }}/{{ $picture->id . '/thumb/' . $picture->picture_file_name }}"></div>--}}
                            {{--@endforeach--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="content-product-info">--}}
                        {{--<div class="content-product-info-header">{{ $product->name }}</div>--}}
                        {{--<div class="content-product-info-price">{{ $product->base_price * env('DOLLAR', '62') }}<br/>--}}
                            {{--<a href='#' id="addToCartButton{{ $product->id }}"--}}
                               {{--onclick="addToCart({{ $product->id }}); return false" style="color: yellow;">В--}}
                                {{--корзину</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--@endforeach--}}
            {{--</div>--}}
        @endisset
        @isset($products)
            <div class="content">
                @foreach($products as $product)
                    <div class="content-product">
                        <div class="content-product-info-header">{{ $product->name }}</div>
                        <div class="owl-carousel owl-theme">
                            @foreach($product->pictures as $picture)
                                {{--<img src="/img/{{ $picture->id . '/thumb/' . $picture->picture_file_name }}">--}}
                                <div class="item"><img src="{{ env('S3_SITE', 'https://s3-ap-southeast-1.amazonaws.com/zrdesigndb/production/product_pictures') }}/{{ $picture->id . '/medium/' . $picture->picture_file_name }}"></div>
                            @endforeach
                        </div>
                    </div>
                    <div class="content-product-info">
                        <div class="content-product-info-price"><button>{{ $product->base_price * env('DOLLAR', '62') }} руб.</button></div>
                        <div class="content-product-info-cart"><button><a href='#' id="addToCartButton{{ $product->id }}"
                               onclick="addToCart({{ $product->id }}); return false" style="color: black; text-decoration: none">В
                                    корзину</a></button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endisset
    </div>
    <div class="pagination">
        @isset($products)
            @isset($prev)
                <button class="pagination-button-true"><a href="{{ route('products', array_merge($parameters, ['page' => $prev])) }}">Обратно</a></button>
            @else
                <button class="pagination-button-false">Обратно</button>
            @endisset
            @isset($next)
                <button class="pagination-button-true"><a href="{{ route('products', array_merge($parameters, ['page' => $next])) }}">Дальше</a></button>
            @else
                <button class="pagination-button-false">Дальше</button>
            @endisset
        @endisset
    </div>
</div>

{{--<script src="js/jquery-3.3.1.slim.min.js"></script>--}}
<!--script(src="assets/js/jquery.touchSwipe.min.js")-->
<script src="js/scripts.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        $('.owl-carousel').owlCarousel({
            loop:false,
            margin:10,
            nav:false,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1000:{
                    items:3
                }
            }
        })
    })
</script>

<script>
    window.brands = document.querySelectorAll('.brand__list')
    window.models = document.querySelectorAll('.model__list')

    function jsMenu(e) {
        var totalWidth = 0;
        $(this).find('li').each(function (i) {
            totalWidth += parseInt($(this).outerWidth(), 10)
        });

        // Find the cursor ratio and position the menu
        var l = (window.innerWidth - totalWidth) * e.pageX / (window.innerWidth - 20);
        $(this).find('li').css('transform', 'translateX(' + l + 'px)');
    }

    // $('.manufacturers').mousemove(jsMenu)

    function showBrand(event, id) {
        const active = document.querySelector('.brand__list.active')
        const activeModel = document.querySelector('.model__list.active')
        if (activeModel) {
            activeModel.classList.remove('active')
        }
        if (active) {
            active.classList.remove('active')
        }

        const menu = document.getElementById(`brand_${id}`);
        menu.classList.add('active')
        window.localStorage.setItem('activeBrand', id)
    }

    function getQueryStringParams(query) {
        return query
            ? (/^[?#]/.test(query) ? query.slice(1) : query)
                .split('&')
                .reduce((params, param) => {
                        let [key, value] = param.split('=');
                        params[key] = value ? decodeURIComponent(value.replace(/\+/g, ' ')) : '';
                        return params;
                    }, {}
                )
            : {}
    };

    function showModel(event, id) {
        const active = document.querySelector('.model__list.active')
        if (active) {
            active.classList.remove('active')
        }

        const model = document.getElementById(`model_${id}`);

        if(model) {
            model.classList.add('active')
            window.localStorage.setItem('activeModel', id)
        }
    }

    function restoreFromStorage() {
        const activeModel = localStorage.getItem('activeModel');
        const activeBrand = localStorage.getItem('activeBrand');
        showBrand(null, activeBrand)
        showModel(null, activeModel)
    }

    document.addEventListener('DOMContentLoaded', function () {
            const {body} = getQueryStringParams(window.location.search)

            if (body) {
                restoreFromStorage()
            }
    })
</script>

</body>
</html>