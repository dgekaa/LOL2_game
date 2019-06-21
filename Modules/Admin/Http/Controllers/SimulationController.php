<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Classes\Games\LifeOfLuxury2\GameDirector as Lol2GameDirector;

class SimulationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('admin::simulations.index');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function showLol2()
    {
        return view('admin::simulations.lol2');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function executeSimulationLol2(Request $request)
    {
        $responseJson = (new Lol2GameDirector())
            ->build('demo')
            ->executeAction([
                'game_id' => 2,
                'user_id' => 1,
                'mode' => 'demo',
                'action' => 'simulation',
                'session_uuid' => '',
                'token' => '',
                'linesInGame' => $request->input('linesInGame'),
                'lineBet' => $request->input('lineBet'),
                'spin_count' => $request->input('spin_count')
            ]);

        $response = json_decode($responseJson);

        $statisticSymbolsInWinBonus = [0,0,0,0,0,0]; // [кол-во символов => кол-во выигрышных выпадений]
        foreach ($response->statisticsData->statisticOfWinBonusCombinations as $key => $syblols) {
            foreach ($syblols as $key2 => $value) {
                $statisticSymbolsInWinBonus[$key] += $value;
            }
        }

        // приведение минимального кол-ва выпавших алмазов в featureGame к понятному числу
        if ($response->statisticsData->minDroppendDiamandsInFeatureGame === 9999) {
            $response->statisticsData->minDroppendDiamandsInFeatureGame = $response->statisticsData->maxDroppendDiamandsInFeatureGame;
        }
        
        return view('admin::simulations.lol2',
            [
                'statisticsData' => $response->statisticsData,
                'statisticSymbolsInWinBonus' => $statisticSymbolsInWinBonus,
                'executionTime' => $response->systemData->executionTime,
                'spinCount' => $request->input('spin_count'),
                'lineBet' => (int) $request->input('lineBet')
            ]
        );
    }


}
