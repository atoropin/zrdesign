@extends('layouts.app')

<div class="main-container">

@section('title', 'Cart')

    <p>Ваша корзина</p>

    <p>
        @foreach($uCart as $item)
            {{ $item->product->name }} <b>{{ $item->product->manufacturer->name }}</b>, {{ ($item->product->base_price)*58 }} руб [<a href="/cart/delete/{{ $item->id }}">X</a>]<br>
            <?php $total += ($item->product->base_price)*58; ?>
        @endforeach
        {{ $total }} руб
    </p>

</div>

</body>
</html>