@extends('layouts.app')

@section('content')
    @foreach($urls as $url)
        <div>{{ $url->name }}</div>
    @endforeach
@endsection
