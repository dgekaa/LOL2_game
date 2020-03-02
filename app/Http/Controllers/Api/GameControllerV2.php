<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Classes\Games\LifeOfLuxury2\GameDirector;

class GameControllerV2 extends Controller
{
    /**
     * Выполнение любого запроса, который приходит в игру
     *
     * @return json ответ в формате json
     */
    public function action(Request $request)
    {
        $gameId = (int) $request->input('game_id');
        $mode = (string) $request->input('mode');

        if ($gameId === 6) {
            $response = (new GameDirector())
                ->build($mode)
                ->executeAction($request->all());
        }

        return $response;
    }
}
