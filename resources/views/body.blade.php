<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<style>
    body {
        width: 960px;

        background: #000;
    }

    h2 {
        color: #ccc;
    }

    h3 {
        color: #ccc;
    }
</style>

<?php dd($body) ?>

<h2>{{ $body->model->name }}</h2>

<h3>{{ $body->id }}</h3>


</body>
</html>