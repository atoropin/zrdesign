<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <ul>
        @foreach ($carBrands as $carBrand)
            <a href="/car_brand/{{ $carBrand->id }}"><li style="display: inline; border: 1px solid #000; padding: 5px; margin: 2px;">{{ $carBrand->name }}</li></a>
        @endforeach
    </ul>
    @foreach ($carBrands as $carBrand)
        @foreach($carBrand->models as $model)
            {{ $model->name }}
        @endforeach
    @endforeach
</body>
</html>