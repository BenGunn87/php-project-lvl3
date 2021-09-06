@extends('layouts.app')

@section('menu')
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" href="{{route('urls.create')}}">Главная</a>
            </li>
            <li class="nav-item">xx
                <a class="nav-link " href="{{route('urls.store')}}">Сайты</a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="jumbotron jumbotron-fluid bg-dark">
        <div class="container-lg">
            <div class="row">
                <div class="col-12 col-md-10 col-lg-8 mx-auto text-white">
                    <h1 class="display-3">Анализатор страниц</h1>
                    <p class="lead">Бесплатно проверяйте сайты на SEO пригодность</p>
                    <form action="{{route('urls.store')}}" method="post" class="d-flex justify-content-center">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <input type="text" name="url[name]" value="{{$url['name'] ?? ''}}" class="form-control form-control-lg" placeholder="https://www.example.com">
                        <input type="submit" value="Проверить" class="btn btn-lg btn-primary ml-3 px-5 text-uppercase">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
