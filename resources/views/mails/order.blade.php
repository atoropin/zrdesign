<h2>Дата заказа: <i>{{ $order->date }}</i></h2>
<h3>Заказчик:</h3>
<table style="border-collapse: collapse; border: 1px solid #cccccc; width: 50%;">
    <tr style="border-collapse: collapse; border: 1px solid #eeeeee;">
        <td><b>Имя</b></td><td>{{ $order->name ? $order->name : "не указан" }}</td>
    </tr>
    <tr style="border-collapse: collapse; border: 1px solid #eeeeee;">
        <td><b>Телефон</b></td><td>{{ $order->phone ? $order->phone : "не указан" }}</td>
    </tr>
    <tr style="border-collapse: collapse; border: 1px solid #eeeeee;">
        <td><b>E-mail</b></td><td>{{ $order->email ? $order->email : "не указан" }}</td>
    </tr>
    <tr style="border-collapse: collapse; border: 1px solid #eeeeee;">
        <td><b>Сообщение</b></td><td>{{ $order->message ? $order->message : "без сообщения" }}</td>
    </tr>
</table>
<h3>Позиции:</h3>
<table style="border-collapse: collapse; border: 1px solid #cccccc; width: 100%;">
    <tr style="border-collapse: collapse; border: 1px solid #eeeeee;">
        <td><b>Артикул</b></td>
        <td><b>Наименование</b></td>
        <td><b>Производитель</b></td>
        <td><b>Цена (у.е.), Курс</b></td>
        <td><b>Цена (руб.)</b></td>
    </tr>
    @foreach($order->items as $item)
        <tr style="border-collapse: collapse; border: 1px solid #eeeeee;">
            <td>{{ $item['art'] }}</td>
            <td>{{ $item['name'] }}</td>
            <td>{{ $item['manufacturer']['name'] }}</td>
            <td>@if($item['base_price'] == 0)-@else{{ $item['base_price'] }} ({{ $item['manufacturer']['currency']['code'] }}, {{ (int)$item['manufacturer']['currency']['exchange_rate'] }})@endif</td>
            <td>@if($item['base_price'] == 0)Цена по запросу@else{{ strrev(chunk_split(strrev($item['base_price'] * (int)$item['manufacturer']['currency']['exchange_rate']), 3, ' ')) }}@endif</td>
        </tr>
    @endforeach
    <tr style="border-collapse: collapse; border: 1px solid #eeeeee;">
        <td colspan="4" style="text-align: right"><u>Общая стоимость:</u> {{ strrev(chunk_split(strrev((int)$order->total), 3, ' ')) }} руб.</td>
    </tr>
</table>