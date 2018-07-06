@extends('layouts.app')

@section('navigation')
    <ul class="main-navigation">
        @foreach ($carBrands as $brand)
            @if(isset($carBody) and ($brand->name == $carBody->model->brand->name))
                <u><li><a href="#">{{ $brand->name }}</a></u>
            @else
                <li><a href="#">{{ $brand->name }}</a>
                    @endif
                    <ul>
                        @foreach($brand->models as $model)
                            @if(isset($carBody) and ($model->name == $carBody->model->name))
                                <u><li><a href="#">{{ $model->name }}</a></u>
                            @else
                                <li><a href="#">{{ $model->name }}</a>
                                    @endif
                                    <ul>
                                        @foreach($model->bodies as $body)
                                            @if(isset($carBody) and ($body->name == $carBody->name))
                                                <u><li><a href="/body/{{ $body->id }}">{{ $body->name }}</a></li></u>
                                            @else
                                                <li><a href="/body/{{ $body->id }}">{{ $body->name }}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                                @endforeach
                    </ul>
                </li>
                @endforeach
                <li>
                    <a href="/cart/view">Корзина</a>
                </li>
    </ul>
@endsection

@section('manufacturers')
    <ul>
        @isset($carBody->manufacturers)
            @foreach($carBody->manufacturers as $manufacturer)
                <li>{{ $manufacturer->name }} (id {{ $manufacturer->id }})</li>
            @endforeach
        @endisset
    </ul>
@endsection

@section('groups')
    <div class="left-menu">
        @isset($carBody->groups)
            @foreach($carBody->groups as $group)
                <a href="?group={{ $group->id }}">{{ $group->name }}</a><br>
            @endforeach
        @endisset
    </div>
@endsection

@section('content')
    <h1>{{ $carBody->model->brand->name }}</h1>

    <h2>{{ $carBody->model->name }}</h2>

    <h3>{{ $carBody->name }}</h3>

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

    @isset($carBodyFiltered->products)
        @foreach($carBodyFiltered->products as $product)
            <h3>{{ $product->name }} ({{ ($product->base_price)*58 }})</h3>
            @foreach($product->pictures as $picture)
                {{ $picture->picture_file_name }}<br>
            @endforeach
            <a href='#' id="addToCartButton{{ $product->id }}" onclick="addToCart({{ $product->id }}); return false" style="color: yellow;">Добавить в корзину<a/>
        @endforeach
    @endisset
@endsection