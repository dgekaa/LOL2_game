@extends('admin::layouts.master')

@section('content')
<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h3>Life Of Luxury</h3>
				<div class="work_space">
					Total spins (number) = {{$statistics->spinCount}}<br />
					Total bet = {{$statistics->totalBet}}<br />
					Total win = {{$statistics->winnings}}<br />
					Number of winning spins = {{$statistics->winSpinCountInMainGame}}<br />
					Number of losing spins = {{$statistics->loseSpinCountInMainGame}}<br />
					Number of free spins = {{$statistics->winSpinCountInFeatureGame}}<br />
					money returned on main game = {{$statistics->winningsOnMainGame}}<br />
					money returned on freespin = {{$statistics->winningsOnFeatureGame}}<br />
					<br />
				</div>
			</div>
        </div>
    </div>
</div>
@stop
