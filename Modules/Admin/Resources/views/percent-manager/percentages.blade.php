@extends('admin::layouts.master')

@section('content')
    <div class="container">
            <form action="{{$alias}}" method="post">
                {{ csrf_field() }}

                <div class="row">
                    @foreach ($percentagesRules as $percentagesRule)

                        <div class="col-3">
                            <b>Main game with bet = {{$percentagesRule->bet}}</b>
                            @foreach ($percentagesRule->mainGame as $drumNumber => $percentages)
                                <div>
                                    <div>
                                        Drum {{$drumNumber}}:
                                    </div>

                                    @foreach ($percentages as $symbol => $percent)
                                        <div class="row">
                                            <div class="col-4">
                                                Symbol {{$symbol}}:
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name='{"type":"mainGame","bet":{{$percentagesRule->bet}},"drum":{{$drumNumber}},"symbol":{{$symbol}}}' value="{{$percent}}" style="width: 40px">
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            @endforeach
                        </div>

                        <div class="col-3">
                            <b>Feature game with bet = {{$percentagesRule->bet}}</b>
                            @foreach ($percentagesRule->featureGame as $drumNumber => $percentages)
                                <div>
                                    Drum {{$drumNumber}}:

                                    @foreach ($percentages as $symbol => $percent)
                                        <div class="row">
                                            <div class="col-4">
                                                Symbol {{$symbol}}:
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name='{"type":"featureGame","bet":{{$percentagesRule->bet}},"drum":{{$drumNumber}},"symbol":{{$symbol}}}' value="{{$percent}}" style="width: 40px">
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            @endforeach
                        </div>
                    @endforeach

                </div>
                <input class="btn" type="submit" value="Apply">
            </form>
    </div>
@stop
