<!DOCTYPE html>
<html>
<head>
    <title>ZR-Design - @yield('title')</title>
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}">
</head>
<body>

<div class="main-container">

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
                                    <li><a href="/body/{{ $body->id }}">{{ $body->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>

    @yield('manufacturers')

    @yield('groups')

    <div class="content-container">
        @yield('content')
    </div>

</div>

</body>
</html>