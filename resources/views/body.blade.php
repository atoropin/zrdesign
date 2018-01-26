@extends('layouts.app')

@section('tuning')
    <div class="left-menu">
        Аэродинамика
        <br>
        Подвеска
        <br>
        Двигатель
    </div>
@endsection

@section('content')
    <h1>{{ $carBody->model->brand->name }}</h1>

    <h2>{{ $carBody->model->name }}</h2>

    <h3>{{ $carBody->name }}</h3>
@endsection