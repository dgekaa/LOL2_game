@extends('admin::layouts.master')

@section('content')
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
        <div class="row">
            <h1>Life of Luxury 2</h1>
            <div class="col-6">
                <div class="work_space">
                    <form
                       action="{{$alias}}"

                       method="post">

                       {{ csrf_field() }}

                        <div class="row_block">
                            <div class="left_side">
                                <label for="lines">lines:</label>
                            </div>
                            <div class="right_side">
                                <input type="text" id="lines" name="lines_in_game" value="@if(isset($data->linesInGame)) {{$data->linesInGame}} @else 20 @endif">
                            </div>
                        </div>
                        <div class="row_block">
                            <div class="left_side">
                                <label for="bet">bet per line:</label>
                            </div>
                            <div class="right_side">
                                <select name="line_bet">
                                    @for ($i = 1; $i <= 20; $i++)
                                        <option value="{{$i}}"
                                            @if (!isset($data->lineBet) && $i === 1) selected @endif
                                            @if(isset($data->lineBet) && $i == $data->lineBet) selected @endif>
                                        {{$i/100}}</option>
                                    @endfor
                                </select>

                            </div>
                        </div>
                        <div class="row_block">
                            <div class="left_side">
                                <label for="spin_count">Spin count:</label>
                            </div>
                            <div class="right_side">
                                <input type="text" id="spin_count" name="spin_count" value="@if (isset($data->spinCount)) {{$data->spinCount}} @else 100000 @endif">
                            </div>
                        </div>

                        <div class="btn-wrap">
                            <button class="btn">Begin</button>
                        </div>

                    </form>
                </div>
            </div>
            <div class="col-6">
                <div class="work_space">
                    Total bet = @if (isset($data->userStatisticsData->loss)) {{$data->userStatisticsData->loss}} @else 0 @endif <br>
                    Total win = @if (isset($data->userStatisticsData->winnings)) {{$data->userStatisticsData->winnings}} @else 0 @endif<br><br> <!-- total winnings in the main game -->
                    Spins Count = @if (isset($data->userStatisticsData->spinCountInMainGame)) {{$data->userStatisticsData->spinCountInMainGame}} @else 0 @endif <br>
                    Win Spins Count = @if (isset($data->userStatisticsData->winSpinCountInMainGame)) {{$data->userStatisticsData->winSpinCountInMainGame}} @else 0 @endif<br>
                    Lose Spins Count = @if (isset($data->userStatisticsData->loseSpinCountInMainGame)) {{$data->userStatisticsData->loseSpinCountInMainGame}} @else 0 @endif<br>
                    Win Spins Amount = @if (isset($data->userStatisticsData->winningsOnMainGame)) {{$data->userStatisticsData->winningsOnMainGame}} @else 0 @endif<br>
                    Win spin % = @if (isset($data->userStatisticsData->percentWinSpinsInMainGame)) {{$data->userStatisticsData->percentWinSpinsInMainGame}} @else 0 @endif
                    <br>
                    <br>
                    Free Spins Count = @if (isset($data->userStatisticsData->featureGamesDropped)) {{$data->userStatisticsData->featureGamesDropped}} @else 0 @endif<br>
                    Free Spins Amount = @if (isset($data->userStatisticsData->winningsOnFeatureGame)) {{$data->userStatisticsData->winningsOnFeatureGame}} @else 0 @endif<br>
                    Win spin % = @if (isset($data->userStatisticsData->percentWinSpinsInFeatureGame)) {{$data->userStatisticsData->percentWinSpinsInFeatureGame}} @else 0 @endif<br><br>

                    PAYOUT = @if (isset($data->userStatisticsData->winPercent)) {{$data->userStatisticsData->winPercent}} @else 0 @endif %<br>
                    PAYOUT by Spins = @if (isset($data->userStatisticsData->winPercentOnMainGame)) {{$data->userStatisticsData->winPercentOnMainGame}} @else 0 @endif %<br>
                    PAYOUT by Free Spins = @if (isset($data->userStatisticsData->winPercentOnFeatureGame)) {{$data->userStatisticsData->winPercentOnFeatureGame}} @else 0 @endif %<br>

                    execution time = @if (isset($data->systemData->executionTime)) {{$data->systemData->executionTime}} @else @endif sec<br><br>

                    <hr>
                    <br>
                    Combination statistics:<br>

                    @if (isset($data->userStatisticsData->statisticOfWinCombinationsInMainGame))
                        @foreach ($data->userStatisticsData->statisticOfWinCombinationsInMainGame[0] as $key => $count)
                            @if($key > 2)
                                Diamond ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($data->userStatisticsData->statisticOfWinCombinationsInMainGame[1] as $key => $count)
                            @if($key > 1)
                                Plane ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($data->userStatisticsData->statisticOfWinCombinationsInMainGame[9] as $key => $count)
                            @if($key > 2)
                                Yacht ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($data->userStatisticsData->statisticOfWinCombinationsInMainGame[4] as $key => $count)
                            @if($key > 2)
                                Car ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($data->userStatisticsData->statisticOfWinCombinationsInMainGame[5] as $key => $count)
                            @if($key > 2)
                                Ring ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($data->userStatisticsData->statisticOfWinCombinationsInMainGame[3] as $key => $count)
                            @if($key > 2)
                                Dollar ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($data->userStatisticsData->statisticOfWinCombinationsInMainGame[6] as $key => $count)
                            @if($key > 2)
                                Watch ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($data->userStatisticsData->statisticOfWinCombinationsInMainGame[7] as $key => $count)
                            @if($key > 2)
                                Gold ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($data->userStatisticsData->statisticOfWinCombinationsInMainGame[2] as $key => $count)
                            @if($key > 2)
                                Silver ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($data->userStatisticsData->statisticOfWinCombinationsInMainGame[8] as $key => $count)
                            @if($key > 2)
                                Bronze ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($data->statisticSymbolsInWinBonus as $key => $count)
                            @if($key > 2)
                                Coin ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                    @else

                    @endif

                    <br>
                    <hr>
                    <br>

                    @if (isset($data->userStatisticsData->statisticsOfDroppedSymbolsInMainGame[0]))
                        Diamonds in the main game: {{$data->userStatisticsData->statisticsOfDroppedSymbolsInMainGame[0]}}<br>
                        Diamonds in the freespin game: {{$data->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame[0]}}<br>
                    @else
                        Diamonds in the main game: 0<br>
                        Diamonds in the freespin game: 0<br>
                    @endif
                    <br>

                    Dropped coins in one spin:<br>
                    @if (isset($data->userStatisticsData->droppedBonusSymbolsInOneSpinInMainGame))
                        @for($key = 5; $key > 0; $key--)
                            Coin ({{$key}}) {{$data->userStatisticsData->droppedBonusSymbolsInOneSpinInMainGame[$key]}}<br>
                        @endfor
                    @endif
                    <br>

                    Which led to the bonus game:<br>
                    @if (isset($data->userStatisticsData->statisticOfWinBonusCombinations))
                        5 coins: {{$data->userStatisticsData->statisticOfWinBonusCombinations[5][0]}}<br>
                        4 coins + 1 diamonds: {{$data->userStatisticsData->statisticOfWinBonusCombinations[5][1]}}<br>
                        3 coins + 2 diamonds: {{$data->userStatisticsData->statisticOfWinBonusCombinations[5][2]}}<br>
                        2 coins + 3 diamonds: {{$data->userStatisticsData->statisticOfWinBonusCombinations[5][3]}}<br>
                        <br>
                        4 coins: {{$data->userStatisticsData->statisticOfWinBonusCombinations[4][0]}}<br>
                        3 coins + 1 diamonds: {{$data->userStatisticsData->statisticOfWinBonusCombinations[4][1]}}<br>
                        2 coins + 2 diamonds: {{$data->userStatisticsData->statisticOfWinBonusCombinations[4][2]}}<br>
                        1 coins + 3 diamonds: {{$data->userStatisticsData->statisticOfWinBonusCombinations[4][3]}}<br>
                        <br>
                        3 coins: {{$data->userStatisticsData->statisticOfWinBonusCombinations[3][0]}}<br>
                        2 coins + 1 diamonds: {{$data->userStatisticsData->statisticOfWinBonusCombinations[3][1]}}<br>
                        1 coins + 2 diamonds: {{$data->userStatisticsData->statisticOfWinBonusCombinations[3][2]}}<br>
                        <br>
                    @endif

                    Minimum number of diamonds from the freespins game @if (isset($data->userStatisticsData->minDroppendDiamandsInFeatureGame)) {{$data->userStatisticsData->minDroppendDiamandsInFeatureGame}} @else 0 @endif <br>
                    Maximum number of diamonds from the freespins game @if (isset($data->userStatisticsData->maxDroppendDiamandsInFeatureGame)) {{$data->userStatisticsData->maxDroppendDiamandsInFeatureGame}} @else 0 @endif <br>

                </div>
            </div>
        </div>
    </div>
@stop
