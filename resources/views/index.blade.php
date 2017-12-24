<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <h1>Car Brands</h1>
    @foreach ($cars as $car)
    {{ $car->name }}<br>
    @endforeach
</body>
</html>