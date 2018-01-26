@extends('layouts.app')

@section('manufacturers')
    <ul>
        @foreach($carBody->manufacturers as $manufacturer)
            <li>{{ $manufacturer->name }}</li>
        @endforeach
    </ul>
@endsection

@section('groups')
    <div class="left-menu">
        @foreach($carBody->groups as $group)
            {{ $group->name }}<br>
        @endforeach
    </div>
@endsection

@section('content')
    <h1>{{ $carBody->model->brand->name }}</h1>

    <h2>{{ $carBody->model->name }}</h2>

    <h3>{{ $carBody->name }}</h3>
@endsection