<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Admin\Repositories\GameReposiroty;
use Modules\Admin\Repositories\GameStatisticReposiroty;

/**
 * Контролер который занимается выводом страниц связанных с статистикой игр
 */
class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $games = GameReposiroty::getWorkGames();

        return view('admin::statistics.index', ['games' => $games]);
    }

    /**
     * Show the specified resource.
     *
     * @return Response
     */
    public function show(string $alias): View
    {
        $mode = 'full';
        $game = GameReposiroty::getGameByAlias($alias);
        $gameStatistics = GameStatisticReposiroty::getGameStatistics($game->id, $mode);

        if (!$gameStatistics) {
            exit('Нет статистики');
        }

        $statistics = json_decode($gameStatistics->statistics);

        return view('admin::statistics.' . $alias, [
            'alias' => $alias,
            'statistics' => $statistics
        ]);
    }
}
