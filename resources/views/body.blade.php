@extends('layouts.app')

@section('tuning')
    @parent
    <ul>
        <li>
            fdsfdsfd
        </li>
    </ul>
@endsection

<?php dd($carBody->products[0]->group) ?>

@section('content')
    <h1>{{ $carBody->model->brand->name }}</h1>

    <h2>{{ $carBody->model->name }}</h2>

    <h3>{{ $carBody->name }}</h3>
@endsection