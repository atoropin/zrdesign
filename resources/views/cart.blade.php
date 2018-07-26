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

    <p>

        <form method="POST" action="/cart/send">
            {{ csrf_field() }}
            <div>
                <label for="Name">Name: </label>
                <input type="text" class="form-control" id="name" placeholder="Your name" name="name" required>
            </div>

        <div>
        <label for="email">Email: </label>
                <input type="text" class="form-control" id="email" placeholder="john@example.com" name="email" required>
            </div>

        <div>
        <label for="message">message: </label>
                <textarea type="text" class="form-control luna-message" id="message" placeholder="Type your messages here" name="message" required></textarea>
            </div>

        <div>
        <button type="submit" class="btn btn-primary" value="Send">Send</button>
            </div>
        </form>

    </p>

</div>

</body>
</html>