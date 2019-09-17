<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Classes\Bridge777Games\BridgeService;
use App\Classes\Bridge777Games\BridgeApi;
use Webpatser\Uuid\Uuid;

class BridgeController extends Controller
{
    /**
     * Запуск игры
     * Запуск выполняется следующим образом. От сервера сайта 777games отправляется
     * запрос содержащий данные, которые необходимы для отправки запросов
     * к их апи. Получаемые данные от 777games наш сервер делает переадресацию
     * и передает их фронту, где они
     * сохраняются и при последующих запросах с фронта уже на наш сервер отправляются.
     * Наш сервер использует эти данные для отправки запросов к апи 777games.
     *
     * @param  Request $request
     */
    public function startGame(Request $request)
    {
        $token = (string) $request->input('token'); // токен от сайта 777games
        $userId = $request->input('userId');
        $nickname = $request->input('nickname');
        $gameId = $request->input('gameId');
        $demo = $request->input('demo');
        $platformId = $request->input('platformId');

        // преобразование параметро demo в парамет mode
        if ($demo === 'false') {
            $mode = 'full';
        } else {
            $mode = 'demo';
        }

        // подготовка get параметров для игры
        $getParams = "game_id=$gameId&user_id=$userId&mode=$mode&token=$token&platformId=$platformId";

        // получение и сохранение баланса пользователя
        BridgeService::addUserBalance(
            $token,
            $gameId,
            $userId,
            $mode,
            $platformId
        );

        // переадресация на игру
        if ($_GET['gameId'] === '6') {
            header("Location: https://gamelux.play777games.com/games/lifeOfLuxury2/?{$getParams}");
            //header("Location: http://play777games/games/lifeOfLuxury2/?{$getParams}");
            die();
        }
    }

    public static function addCreadit(
        Request $request
    ): string {
        $requestData = array(
            'token' => $request->input('token'),
            'userId' => $request->input('user_id'),
            'gameId' => $request->input('game_id'),
            'platformId' => $request->input('platformId'),
            'direction' => 'debit',
            'eventType' => 'BetPlacing',
            'amount' => 0,
            'extraInfo' => [],
            'eventID' => Uuid::generate()->string
        );

        // получение ответа от slot.pantera
        $responseMoveFunds = BridgeApi::sendMoveFunds($requestData);

        return $responseMoveFunds;
    }
}
