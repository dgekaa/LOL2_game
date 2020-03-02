@extends('admin::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($games as $game)
                <a href="statistics/{{$game->alias}}">{{$game->name}}</a>
            @endforeach
        </div>
    </div>
@stop
