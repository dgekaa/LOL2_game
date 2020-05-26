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
                        @foreach ($data->userStatisticsData->statisticOfWinCombinationsInMainGame[1] as $key => $count)
                            @if($key > 1)
                                Plane ({{$key}}) {{$count}}<br>
                            @endif
                        @endforeach
                        <br>
                        @foreach ($data->userStatisticsData->statisticOfWinCombinationsInMainGame[9] as $key => $count)
                            @if($key > 1)
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
                    @else

                    @endif

                    <br>
                    <hr>
                    <br>

                    @if (isset($data->userStatisticsData->droppedBonusSymbolsInOneSpinInMainGame))
                    <table border="1" cellspacing="2" width="500">
                        <tr>
                            <td>
                                Coins in the main game
                            </td>
                            <td>
                                {{ $data->userStatisticsData->statisticsOfDroppedSymbolsInMainGame[10] }}
                            </td>
                            <td>
                                Coins in the free spin
                            </td>
                            <td>
                                {{ $data->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame[10] }}
                            </td>
                        </tr>
                        @for($key = 5; $key > 0; $key--)
                            <tr>
                                <td>
                                    {{$key}} Coins
                                </td>
                                <td>
                                    {{$data->userStatisticsData->droppedBonusSymbolsInOneSpinInMainGame[$key]}}
                                </td>
                                <td>
                                    {{$key}} Coins
                                </td>
                                <td>
                                    {{$data->userStatisticsData->droppedBonusSymbolsInOneSpinInFeatureGame[$key]}}
                                </td>
                            </tr>
                        @endfor
                        <tr>
                            <td colspan="4">&nbsp;</td>
                        <tr>
                            <td>
                                Diamonds in the main game
                            </td>
                            <td>
                                @php
                                    $diamondsInMainGame = json_decode(json_encode($data->userStatisticsData->diamondsInMainGame), true);
                                    unset($diamondsInMainGame[0]);

                                    $diamondsSumInMainGame = 0;
                                    foreach ($diamondsInMainGame as $key => $diamond) {
                                        $diamondsSumInMainGame += $diamond * $key;
                                    }
                                @endphp
                                {{ $diamondsSumInMainGame }}
                            </td>
                            <td>
                                Diamonds in the free spin
                            </td>
                            <td>
                                @php
                                    $diamondsInFeatureGame = json_decode(json_encode($data->userStatisticsData->diamondsInFeatureGame), true);
                                    unset($diamondsInFeatureGame[0]);

                                    $diamondsSumInFeatureGame = 0;
                                    foreach ($diamondsInFeatureGame as $key => $diamond) {
                                        $diamondsSumInFeatureGame += $diamond * $key;
                                    }
                                @endphp
                                {{ $diamondsSumInFeatureGame }}
                            </td>
                        </tr>
                        @for($key = 3; $key > 0; $key--)
                            <tr>
                                <td>
                                    {{ $key }} Diamonds
                                </td>
                                <td>
                                    {{ array_key_exists($key, $diamondsInMainGame) ? $diamondsInMainGame[$key] : 0 }}
                                </td>
                                <td>
                                    {{ $key }} Diamonds
                                </td>
                                <td>
                                    {{ array_key_exists($key, $diamondsInFeatureGame) ? $diamondsInFeatureGame[$key] : 0 }}
                                </td>
                            </tr>
                        @endfor
                        @if (isset($data->userStatisticsData->statisticOfWinBonusCombinations))
                            <tr>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Free Spins Count</td>
                                <td></td>
                                <td>Extra Spins Count</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>5 coins</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinations[5][0]}}</td>
                                <td>5 coins</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinationsInFeatureGame[5][0]}}</td>
                            </tr>
                            <tr>
                                <td>4 coins + 1 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinations[5][1]}}</td>
                                <td>4 coins + 1 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinationsInFeatureGame[5][1]}}</td>
                            </tr>
                            <tr>
                                <td>3 coins + 2 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinations[5][2]}}</td>
                                <td>3 coins + 2 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinationsInFeatureGame[5][2]}}</td>
                            </tr>
                            <tr>
                                <td>2 coins + 3 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinations[5][3]}}</td>
                                <td>2 coins + 3 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinationsInFeatureGame[5][3]}}</td>
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>4 coins</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinations[4][0]}}</td>
                                <td>4 coins</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinationsInFeatureGame[4][0]}}</td>
                            </tr>
                            <tr>
                                <td>3 coins + 1 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinations[4][1]}}</td>
                                <td>3 coins + 1 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinationsInFeatureGame[4][1]}}</td>
                            </tr>
                            <tr>
                                <td>2 coins + 2 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinations[4][2]}}</td>
                                <td>2 coins + 2 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinationsInFeatureGame[4][2]}}</td>
                            </tr>
                            <tr>
                                <td>1 coins + 3 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinations[4][3]}}</td>
                                <td>1 coins + 3 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinationsInFeatureGame[4][3]}}</td>
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>3 coins</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinations[3][0]}}</td>
                                <td>3 coins</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinationsInFeatureGame[3][0]}}</td>
                            </tr>
                            <tr>
                                <td>2 coins + 1 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinations[3][1]}}</td>
                                <td>2 coins + 1 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinationsInFeatureGame[3][1]}}</td>
                            </tr>
                            <tr>
                                <td>1 coins + 2 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinations[3][2]}}</td>
                                <td>1 coins + 2 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinationsInFeatureGame[3][2]}}</td>
                            </tr>
                            <tr>
                                <td>3 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinations[3][3]}}</td>
                                <td>3 diamonds</td>
                                <td>{{$data->userStatisticsData->statisticOfWinBonusCombinationsInFeatureGame[3][3]}}</td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="4">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Min Diamonds Per One FS Game</td>
                            <td>{{ isset($data->userStatisticsData->minDroppendDiamandsInFeatureGame) ? $data->userStatisticsData->minDroppendDiamandsInFeatureGame : 0 }}</td>
                            <td>{{--Min Extra Spins Triggers Per One FS Game--}}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Max Diamonds Per One FS Game</td>
                            <td>{{ isset($data->userStatisticsData->maxDroppendDiamandsInFeatureGame) ? $data->userStatisticsData->maxDroppendDiamandsInFeatureGame : 0 }}</td>
                            <td>{{--Max Extra Spins Triggers Per One FS Game--}}</td>
                            <td></td>
                        </tr>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
        <script type="text/javascript">
            document.body.querySelector('.btn').addEventListener('click', function () {
                   this.innerHTML = 'in process...'
            })
        </script>
@stop
