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
    <title>ZR Performance and Design</title>
    <meta name="description" content="ZR Performance and Design">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="yandex-verification" content="32bdfc672f81d8db" />
    <link href="favicon.ico" rel="shortcut icon">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?hash={{ rand(0, 1000) }}">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/photoswipe.css">
    <link rel="stylesheet" href="css/default-skin.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/4.13.0/bodymovin.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/photoswipe.js"></script>
    <script src="js/photoswipe-ui-default.js"></script>
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
    function createImageGallery(id, i) {
        const items = $('#product_gallery_'+id)
            .find('img')
            .map((index, image) => ({
            src: $(image).attr('src'),
            w: image.naturalWidth,
            h: image.naturalHeight
        }))

        var pswpElement = document.querySelectorAll('.pswp')[0];
        var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, {index: i});

        gallery.init()
    }

    function addToCart(product) {
        $.ajax({
            type: 'POST',
            url: '/cart/add/' + product,
            success: function (data) {
                $('#addToCartButton' + product).text('Добавлен в корзину!')
                setTimeout(() => {
                    $('#addToCartButton' + product).text('В корзину')
                }, 1000)
                $('#cart').text('Мои покупки '+data.itemsCount)
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
            <div class="header-cart">
                <a href="/cart" class="header-cart-button" id="cart">Мои покупки @isset($cartCount){{ $cartCount }}@else 0 @endisset</a>
            </div>
            <div class="header-brand-menu">
                <ul>
                    @foreach ($brandData as $brand)
                        <li>
                            @if($brand->id == $carBodyInfo['brand_id'])
                                <img onclick="showBrand(event, {{$brand->id}})" class="menu-img"
                                                 src="{{ asset('img/brands/'.$brand->logo_file_name) }}"/>
                            @else
                            <a href="#"><img onclick="showBrand(event, {{$brand->id}})" class="menu-img"
                                             src="{{ asset('img/brands/'.$brand->logo_file_name) }}"/></a>
                            @endif
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
                        <li onclick="showModel(event, {{$model->id}})">
                            @if($model->id == $carBodyInfo['model_id'])
                                <u style="text-decoration-color: #ca2d25;">{{ $model->name }}</u>
                            @else
                                {{ $model->name }}
                            @endif
                        </li>
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
                            <li>
                                @if($body->id == $carBodyInfo['body_id'])
                                    <u style="text-decoration-color: #ca2d25;">{{ $body->name }}</u>
                                @else
                                    <a href="{{ route('products', ['body' => $body->id]) }}">{{ $body->name }}</a>
                                @endif
                            </li>
                            {{--@isset($parameters['body'])--}}
                                    {{--@if($body->id == $parameters['body'])--}}
                                        {{--<li><b>{{ $body->name }}</b></li>--}}
                                    {{--@else--}}
                                        {{--<li><a href="{{ route('products', ['body' => $body->id]) }}">{{ $body->name }}</a></li>--}}
                                    {{--@endif--}}
                                {{--@else--}}
                                    {{--<li><a href="{{ route('products', ['body' => $body->id]) }}">{{ $body->name }}</a></li>--}}
                            {{--@endisset--}}
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
                        @if(isset($parameters['manufacturer']) && $manufacturer->id == $parameters['manufacturer'])
                            <a style="text-decoration: underline #ca2d25;" href="{{ route('products', array_merge($parameters, ['manufacturer' => $manufacturer->id])) }}">{{ mb_strtoupper($manufacturer->name) }}</a>
                        @else
                            <a href="{{ route('products', array_merge($parameters, ['manufacturer' => $manufacturer->id])) }}">{{ mb_strtoupper($manufacturer->name) }}</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="main-container">
        <div class="menu-left-content">
            @isset($parameters['body'])
                <div class="menu-left-back">
                    <a href="{{ route('products', ['body' => $parameters['body']]) }}">Весь список для <b>{{ $bodyName }}</b></a>
                </div>
            @endisset
            <div class="menu-left">
                <ul>
                    @foreach($groups as $group)
                        <li>
                            @if(isset($parameters['group']) && $group->id == $parameters['group'])
                                <a style="text-decoration: underline #ca2d25;" href="{{ route('products', array_merge($parameters, ['group' => $group->id])) }}">{{ $group->name }}</a>
                            @else
                                <a href="{{ route('products', array_merge($parameters, ['group' => $group->id])) }}">{{ $group->name }}</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @isset($productsCarousel)
            {{--<div class="carousel">--}}
                {{--@foreach($productsCarousel as $product)--}}
                    {{--<div class="carousel-product">--}}
                        {{--<div class="content-product-info-header">{{ $product->name }} <a href="{{ route('products', array_merge($parameters, ['manufacturer' => $product->manufacturer->id])) }}">{{ mb_strtoupper($product->manufacturer->name) }}</a></div>--}}
                        {{--<div class="owl-carousel owl-theme" id="product_gallery_{{$product->id}}">--}}
                            {{--@foreach($product->pictures as $picture)--}}
                                {{--<div class="item"><img style="cursor: pointer" onclick="createImageGallery({{$product->id}}, {{$loop->index}})" src="{{ env('S3_SITE', 'https://s3-ap-southeast-1.amazonaws.com/zrdesigndb/production/product_pictures') }}/{{ $picture->id . '/medium/' . $picture->picture_file_name }}"></div>--}}
                            {{--@endforeach--}}
                        {{--</div>--}}
                        {{--<div class="content-product-info-price"><span class="content-product-info-price-button">{{ strrev(chunk_split(strrev($product->base_price * env('DOLLAR', '62')), 3, ' ')) }} руб.</span></div>--}}
                        {{--<div class="content-product-info-cart"><a class="content-product-info-cart-button" href='#' id="addToCartButton{{ $product->id }}"--}}
                                                                  {{--onclick="addToCart({{ $product->id }}); return false" style="text-decoration: none">В корзину</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--@endforeach--}}
            {{--</div>--}}
        @endisset
        @isset($products)
            <div class="content">
                @foreach($products as $product)
                    <div class="content-product">
                        <div class="content-product-info-header">{{ $product->name }} <a href="{{ route('products', array_merge($parameters, ['manufacturer' => $product->manufacturer->id])) }}">{{ mb_strtoupper($product->manufacturer->name) }}</a> <small>{{ $product->art }}</small></div>
                        <div class="owl-carousel owl-theme" id="product_gallery_{{$product->id}}">
                            @foreach($product->pictures as $picture)
                                <div class="item"><img style="cursor: pointer" onclick="createImageGallery({{$product->id}}, {{$loop->index}})" src="{{ env('S3_SITE', 'https://s3-ap-southeast-1.amazonaws.com/zrdesigndb/production/product_pictures') }}/{{ $picture->id . '/original/' . $picture->picture_file_name }}"></div>
                            @endforeach
                        </div>
                    </div>
                    <div class="content-product">
                        {!! nl2br($product->description) !!}
                    </div>
                    <div class="content-product-info">
                        <div class="content-product-info-price"><span class="content-product-info-price-button">
                                @isset($product->manufacturer->currency){{ strrev(chunk_split(strrev($product->base_price * $product->manufacturer->currency->exchange_rate), 3, ' ')) }} руб.@elseЦена по запросу@endisset
                            </span></div>
                        <div class="content-product-info-cart"><a class="content-product-info-cart-button" href='#' id="addToCartButton{{ $product->id }}"
                               onclick="addToCart({{ $product->id }}); return false" style="text-decoration: none">В корзину</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endisset
    </div>
    <div class="pagination">
        @if(isset($totalItems) && $totalItems > 0)
            @isset($prev)
                <a class="pagination-button-true" href="{{ route('products', array_merge($parameters, ['page' => $prev])) }}">Обратно</a>
            @else
                <span class="pagination-button-false">Обратно</span>
            @endisset
            @isset($next)
                <a class="pagination-button-true" href="{{ route('products', array_merge($parameters, ['page' => $next])) }}">Дальше</a>
            @else
                <span class="pagination-button-false">Дальше</span>
            @endisset
        @endif
    </div>
    <footer class="footer">
        <div class="footer-content">
            &copy;{{ \Carbon\Carbon::today()->format('Y') }} zrdesign.ru
        </div>
    </footer>
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

<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe.
         It's a separate element as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides.
            PhotoSwipe keeps only 3 of them in the DOM to save memory.
            Don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                <!-- element will get class pswp__preloader--active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>

        </div>

    </div>

</div>

</body>
</html>