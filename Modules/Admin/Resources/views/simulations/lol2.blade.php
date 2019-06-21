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
                       action="lol2"

                       method="post">

                       {{ csrf_field() }}

                        <div class="row_block">
                            <div class="left_side">
                                <label for="lines">lines:</label>
                            </div>
                            <div class="right_side">
                                <input type="text" id="lines" name="linesInGame" value="@if(isset($linesInGame)) {{$linesInGame}} @else 20 @endif">
                            </div>
                        </div>
                        <div class="row_block">
                            <div class="left_side">
                                <label for="bet">bet per line:</label>
                            </div>
                            <div class="right_side">
                                <select name="lineBet">
                                    @for ($i = 1; $i <= 20; $i++)
                                        <option value="{{$i}}"
                                            @if (!$lineBet && $i === 1) selected
                                            @elseif($i == $lineBet) selected
                                            @endif>
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
                                <input type="text" id="spin_count" name="spin_count" value="@if (isset($spinCount)) {{$spinCount}} @else 100000 @endif">
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
                    Total bet = @if (isset($statisticsData->loss)) {{$statisticsData->loss}} @else 0 @endif <br>
                    Total win = @if (isset($statisticsData->winnings)) {{$statisticsData->winnings}} @else 0 @endif<br><br> <!-- total winnings in the main game -->
                    Spins Count = @if (isset($statisticsData->spinCountInMainGame)) {{$statisticsData->spinCountInMainGame}} @else 0 @endif <br>
                    Win Spins Count = @if (isset($statisticsData->winSpinCountInMainGame)) {{$statisticsData->winSpinCountInMainGame}} @else 0 @endif<br>
                    Lose Spins Count = @if (isset($statisticsData->loseSpinCountInMainGame)) {{$statisticsData->loseSpinCountInMainGame}} @else 0 @endif<br>
                    Win Spins Amount = @if (isset($statisticsData->winningsOnMainGame)) {{$statisticsData->winningsOnMainGame}} @else 0 @endif<br>
                    Win % = @if (isset($statisticsData->winPercentOnMainGame)) {{$statisticsData->winPercentOnMainGame}} @else 0 @endif
                    <br>
                    <br>
                    Free Spins Count = @if (isset($statisticsData->featureGamesDropped)) {{$statisticsData->featureGamesDropped}} @else 0 @endif<br>
                    Free Spins Amount = @if (isset($statisticsData->winningsOnFeatureGame)) {{$statisticsData->winningsOnFeatureGame}} @else 0 @endif<br>
                    Win spin % = @if (isset($statisticsData->percentWinSpinsInFeatureGame)) {{$statisticsData->percentWinSpinsInFeatureGame}} @else 0 @endif<br><br>

                    PAYOUT = @if (isset($statisticsData->winPercent)) {{$statisticsData->winPercent}} @else 0 @endif %<br>
                    PAYOUT by Spins = @if (isset($statisticsData->winPercentOnMainGame)) {{$statisticsData->winPercentOnMainGame}} @else 0 @endif %<br>
                    PAYOUT by Free Spins = @if (isset($statisticsData->winPercentOnFeatureGame)) {{$statisticsData->winPercentOnFeatureGame}} @else 0 @endif %<br>

                    execution time = @if (isset($executionTime)) {{$executionTime}} @else @endif sec<br><br>

                    <hr>
                    <br>
                    Combination statistics:<br>

                    @if (isset($statisticsData->statisticOfWinCombinationsInMainGame))
                        @foreach ($statisticsData->statisticOfWinCombinationsInMainGame[0] as $key => $count)
                            @if($key > 2)
                                Diamond ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($statisticsData->statisticOfWinCombinationsInMainGame[1] as $key => $count)
                            @if($key > 1)
                                Plane ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($statisticsData->statisticOfWinCombinationsInMainGame[9] as $key => $count)
                            @if($key > 2)
                                Yacht ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($statisticsData->statisticOfWinCombinationsInMainGame[4] as $key => $count)
                            @if($key > 2)
                                Car ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($statisticsData->statisticOfWinCombinationsInMainGame[5] as $key => $count)
                            @if($key > 2)
                                Ring ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($statisticsData->statisticOfWinCombinationsInMainGame[3] as $key => $count)
                            @if($key > 2)
                                Dollar ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($statisticsData->statisticOfWinCombinationsInMainGame[6] as $key => $count)
                            @if($key > 2)
                                Watch ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($statisticsData->statisticOfWinCombinationsInMainGame[7] as $key => $count)
                            @if($key > 2)
                                Gold ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($statisticsData->statisticOfWinCombinationsInMainGame[2] as $key => $count)
                            @if($key > 2)
                                Silver ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($statisticsData->statisticOfWinCombinationsInMainGame[8] as $key => $count)
                            @if($key > 2)
                                Bronze ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($statisticSymbolsInWinBonus as $key => $count)
                            @if($key > 2)
                                Coin ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                    @else

                    @endif

                    <br>
                    <hr>
                    <br>

                    @if (isset($statisticsData->statisticsOfDroppedSymbolsInMainGame[0]))
                        Diamonds in the main game: {{$statisticsData->statisticsOfDroppedSymbolsInMainGame[0]}}<br>
                        Diamonds in the freespin game: {{$statisticsData->statisticsOfDroppedSymbolsInFeatureGame[0]}}<br>
                    @else
                        Diamonds in the main game: 0<br>
                        Diamonds in the freespin game: 0<br>
                    @endif
                    <br>

                    Dropped coins in one spin:<br>
                    @if (isset($statisticsData->droppedBonusSymbolsInOneSpinInMainGame))
                        @for($key = 5; $key > 0; $key--)
                            Coin ({{$key}}) {{$statisticsData->droppedBonusSymbolsInOneSpinInMainGame[$key]}}<br>
                        @endfor
                    @endif
                    <br>

                    Which led to the bonus game:<br>
                    @if (isset($statisticsData->statisticOfWinBonusCombinations))
                        5 coins: {{$statisticsData->statisticOfWinBonusCombinations[5][0]}}<br>
                        4 coins + 1 diamonds: {{$statisticsData->statisticOfWinBonusCombinations[5][1]}}<br>
                        3 coins + 2 diamonds: {{$statisticsData->statisticOfWinBonusCombinations[5][2]}}<br>
                        2 coins + 3 diamonds: {{$statisticsData->statisticOfWinBonusCombinations[5][3]}}<br>
                        <br>
                        4 coins: {{$statisticsData->statisticOfWinBonusCombinations[4][0]}}<br>
                        3 coins + 1 diamonds: {{$statisticsData->statisticOfWinBonusCombinations[4][1]}}<br>
                        2 coins + 2 diamonds: {{$statisticsData->statisticOfWinBonusCombinations[4][2]}}<br>
                        1 coins + 3 diamonds: {{$statisticsData->statisticOfWinBonusCombinations[4][3]}}<br>
                        <br>
                        3 coins: {{$statisticsData->statisticOfWinBonusCombinations[3][0]}}<br>
                        2 coins + 1 diamonds: {{$statisticsData->statisticOfWinBonusCombinations[3][1]}}<br>
                        1 coins + 2 diamonds: {{$statisticsData->statisticOfWinBonusCombinations[3][2]}}<br>
                        <br>
                    @endif

                    Minimum number of diamonds from the freespins game @if (isset($statisticsData->minDroppendDiamandsInFeatureGame)) {{$statisticsData->minDroppendDiamandsInFeatureGame}} @else 0 @endif <br>
                    Maximum number of diamonds from the freespins game @if (isset($statisticsData->maxDroppendDiamandsInFeatureGame)) {{$statisticsData->maxDroppendDiamandsInFeatureGame}} @else 0 @endif <br>

                </div>
            </div>
        </div>
    </div>
@stop
