@extends('layouts.app')

@section('menu')
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{route('urls.create')}}">Главная</a>
            </li>
            <li class="nav-item">xx
                <a class="nav-link" href="{{route('urls.store')}}">Сайты</a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="container-lg">
        <h1 class="mt-5 mb-3">Сайт: {{$url->name}}</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tr>
                    <td>ID</td>
                    <td>{{$url->id}}</td>
                </tr>
                <tr>
                    <td>Имя</td>
                    <td>{{$url->name}}</td>
                </tr>
                <tr>
                    <td>Дата создания</td>
                    <td>{{$url->created_at}}</td>
                </tr>
                <tr>
                    <td>Дата обновления</td>
                    <td>{{$url->updated_at}}</td>
                </tr>
            </table>
        </div>
        <h2 class="mt-5 mb-3">Проверки</h2>
        <form method="post" action="{{ route('urls.check', ['id' => $url->id]) }}">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <input type="submit" class="btn btn-primary" value="Запустить проверку">
        </form>
        <table class="table table-bordered table-hover text-nowrap">
            <tr>
                <th>ID</th>
                <th>Код ответа</th>
                <th>Дата создания</th>
            </tr>
            @foreach($url_checks as $check)
                <tr>
                    <td>{{ $check->id }}</td>
                    <td>{{ $check->status_code }}</td>
                    <td>{{ $check->created_at }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
