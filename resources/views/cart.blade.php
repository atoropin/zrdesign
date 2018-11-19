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
    <link href="favicon.ico" rel="shortcut icon">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?hash={{ rand(0, 1000) }}">
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
    function removeFromCart(item) {
        const removeFromCartButton = document.getElementById('removeFromCartButton'+item)

        $.ajax({
            type: 'POST',
            url: '/cart/delete/' + item,
            success: function (data) {
                removeFromCartButton.remove()
                $('#totalPrice').text('Общая стоимость: '+data.totalPrice+' руб.')
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
        </div>
    </header>
    <div class="main-cart-container">
        <div class="menu-cart-content">
            <div class="menu-cart-back">
                <a class="content-product-info-price-button" href="/">Вернуться обратно</a>
            </div>
        </div>
        <div class="cart-content">
            @foreach($uCart as $item)
                <div id="removeFromCartButton{{ $item->id }}">
                    <div class="content-product">
                        <div class="content-product-info-header">{{ $item->product->name }} <a href="{{ route('products', ['manufacturer' => $item->product->manufacturer->id]) }}">{{ mb_strtoupper($item->product->manufacturer->name) }}</a> <small>{{ $item->product->art }}</small></div>
                        <div class="owl-carousel owl-theme">
                            @foreach($item->product->pictures as $picture)
                                {{--<img src="/img/{{ $picture->id . '/thumb/' . $picture->picture_file_name }}">--}}
                                <div class="item"><img src="{{ env('S3_SITE', 'https://s3-ap-southeast-1.amazonaws.com/zrdesigndb/production/product_pictures') }}/{{ $picture->id . '/thumb/' . $picture->picture_file_name }}"></div>
                            @endforeach
                        </div>
                    </div>
                    <div class="content-product-info">
                        <div class="content-product-info-price"><span class="content-product-info-price-button">
                                @isset($item->product->manufacturer->currency){{ strrev(chunk_split(strrev(round($item->product->base_price * $item->product->manufacturer->currency->exchange_rate)), 3, ' ')) }} руб.@elseЦена по запросу@endisset
                            </span></div>
                        <div class="content-product-info-cart"><a class="content-product-info-cart-button" href='#'
                                                                          onclick="removeFromCart({{ $item->id }}); return false" style="text-decoration: none">Удалить</a>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="content-product-info">
                <span class="content-product-info-price-button" id="totalPrice">Общая стоимость: {{ strrev(chunk_split(strrev(round($totalPrice)), 3, ' ')) }} руб.</span>
            </div>
            <div class="cart-form">
                <form method="POST" action="/cart/send">
                    {{ csrf_field() }}
                    <div class="form-input">
                        <label for="name">Ваше имя: </label><br/>
                        <input type="text" id="name" placeholder="Введите Ваше имя" name="name">
                    </div>
                    <div class="form-input">
                        <label for="email">Телефон: </label><br/>
                        <input type="text" id="phone" placeholder="Ваш телефон для связи" name="phone">
                    </div>
                    <div class="form-input">
                        <label for="phone">E-mail: </label><br/>
                        <input type="text" id="email" placeholder="Введите Ваш E-mail" name="email">
                    </div>
                    <div class="form-input">
                        <label for="message">Сообщение (необязательно): </label><br/>
                        <textarea type="text" id="message" name="message"></textarea>
                    </div>
                    <div class="form-input">
                        <button type="submit" value="Send" @if($uCart->isEmpty()) disabled @endif>Отправить заказ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="footer-content">
            &copy;{{ \Carbon\Carbon::today()->format('Y') }} zrdesign.ru <a class="footer-link" href="mailto:order@zrdesign.ru">order@zrdesign.ru</a>
        </div>
    </footer>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        $('.owl-carousel').owlCarousel({
            loop:false,
            margin:10,
            nav:false,
            responsive:{
                0:{
                    items:2
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        })
    })
</script>

</body>
</html>