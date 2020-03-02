<?php

namespace Modules\Admin\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Admin\Repositories\BaseRepository;
use App\Models\V2GameStatistic;

class GameStatisticReposiroty extends BaseRepository
{
    public static function getGameStatistics(int $gameId, string $mode): ?V2GameStatistic
    {
        $gameStatistics = V2GameStatistic::where('game_id', $gameId)->where('mode', $mode)->first();

        return $gameStatistics;
    }
}
