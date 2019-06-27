<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Admin\Repositories\GameReposiroty;
use Modules\Admin\Services\SimulationService;

/**
 * Контролер который занимается выводом страниц связанных с симуляцией игр
 * и запуском симуляции. Симуляция делается с целью получения статистики об
 * работе игры на большом кол-ве итераций.
 */
class SimulationController extends Controller
{
    /** @var array описание "опциии" необходимых для выполнения симуляции
    * Опция выбирается по параемтру alias, который приходит в запросе (является частью url).
    * Данный параметр уникальный для каждой игры и хранится в таблице БД v2_games
    * Содержит набор параметров:
    * gameDirecot - путь к классу IGameDirector, который будет собирать игру
    * gameId - id игры в БД в таблице v2_games
    * view - название представления из папки simulation. Если значение пустое, то
    * предполагается, что параметр будет === alias
    * additional_methonds - названия методов из SimulationService,
    * которые выполняются по порядку и которые принимают и обновляют $data
    * для добавления каких то недостающих данных для конкретной симуляции
    * */
    protected $simulationOptions = [
        'life-of-luxury-2' => [
            'gameDirecot' => '\App\Classes\Games\LifeOfLuxury2\GameDirector',
            'gameId' => 2,
            'view' => '',
            'additionalMethonds' => ['addStatisticSymbolsInWinBonus', 'fixMinDroppendJokersInFeatureGame']
        ]
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $games = GameReposiroty::getWorkGames();

        return view('admin::simulation.index', ['games' => $games]);
    }

    /**
     * Show the specified resource.
     *
     * @return Response
     */
    public function show($alias): View
    {
        return view('admin::simulation.' . $alias, ['alias' => $alias]);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function showResult(
        Request $request,
        string $alias
    ): View {
        $spinCount = $request->input('spin_count');
        $lineBet = $request->input('line_bet');
        $linesInGame = $request->input('lines_in_game');

        // it is array with a data for the GameDirector
        $requestArray = [
            'lines_in_game' => $linesInGame,
            'line_bet' => $lineBet,
            'spin_count' => $spinCount,
            'user_id' => 1,
            'mode' => 'demo',
            'action' => 'simulation',
            'session_uuid' => '',
            'token' => ''
        ];

        // определение директора
        $gameDirector = new $this->simulationOptions[$alias]['gameDirecot'];

        // определение id игры
        $requestArray['game_id'] = $this->simulationOptions[$alias]['gameId'];

        // выполнение симуляции
        $data = SimulationService::execute($requestArray, $alias, $gameDirector);

        // получение дополнительных данных для представления
        foreach ($this->simulationOptions[$alias]['additionalMethonds'] as $key => $value) {
            $data = SimulationService::$value($data);
        }

        // изменение представления
        if ($this->simulationOptions[$alias]['view'] !== '') {
            $alias = $this->simulationOptions[$alias]['view'];
        }

        $data->spinCount = $spinCount;
        $data->lineBet = $lineBet;
        $data->linesInGame = $linesInGame;

        $res1 = 100 / $data->statisticsData->loss * $data->statisticsData->winnings;
        $res2 = 100 / $data->statisticsData->loss * $data->statisticsData->winningsOnMainGame;
        $data->statisticsData->winPercentOnFeatureGame = 100 / $data->statisticsData->loss * $data->statisticsData->winningsOnFeatureGame;

        return view('admin::simulation.' . $alias, [
            'data' => $data,
            'alias' => $alias
        ]);
    }

}
