@extends('layouts.app')

@section('content')
    <form action="{{route('urls.store')}}" method="post">
        <div>
            <label>
                Название *
                <input type="text" name="url[name]" value="{{$url['name'] ?? ''}}">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            </label>
        </div>
        <input type="submit" value="Create">
    </form>
@endsection
