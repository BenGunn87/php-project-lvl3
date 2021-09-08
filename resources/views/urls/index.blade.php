@extends('layouts.app')

@section('menu')
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{route('urls.create')}}">Главная</a>
            </li>
            <li class="nav-item">xx
                <a class="nav-link active" href="{{route('urls.store')}}">Сайты</a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="container-lg">
        <h1 class="mt-5 mb-3">Сайты</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Последняя проверка</th>
                    <th>Код ответа</th>
                </tr>
                @foreach($urls as $url)
                    <tr>
                        <td>{{ $url->id }}</td>
                        <td><a href="{{route('urls.show', ['id' => $url->id])}}">{{ $url->name }}</a></td>
                        <td>{{ $url->checked_at }}</td>
                        <td>{{ $url->status_code }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
