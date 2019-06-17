<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Classes\Bridge777Games\BridgeService;

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
        $token = $request->input('token'); // токен от сайта 777games
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
        $getParams = "game_id=$gameId&user_id=$userId&mode=$mode&token=$token";

        // получение и сохранение баланса пользователя
        BridgeService::addUserBalance(
            $token,
            $gameId,
            $userId,
            $mode
        );

        // переадресация на игру
        if ($_GET['gameId'] === '2') {
            //header("Location: https://game.play777games.com/games/lifeOfLuxury/?{$getParams}");
            header("Location: http://play777games/games/lifeOfLuxury2/?{$getParams}");
            die();
        }
    }

    public function getBalance(Request $request)
    {
        $token = $request->input('token');
        $userId = $request->input('userId');
        $nickname = $request->input('nickname');
        $gameId = $request->input('gameId');
        $demo = $request->input('demo');
        $token = $request->input('token');
        $platformId = $request->input('platformId');

        $responseGetBalance = (new BridgeApiService)->getBalance($token, $userId, $gameId);

        if ($responseGetBalance == false) {
            return json_encode($responseGetBalance);
        }

        return response()->json($responseGetBalance);
    }

    public function sessionCheck(Request $request)
    {
        $token = $request->input('token');
        $userId = $request->input('userId');

        $responseSessionCheck = (new BridgeApiService)->sessionCheck($token, $userId);

        if ($responseSessionCheck == false) {
            return json_encode($responseSessionCheck);
        }

        return response()->json($responseSessionCheck);
    }

    public function moveFunds(Request $request)
    {
        $params = [
            'token' => $request->input('token'),
            'userId' => $request->input('userId'),
            'gameId' => $request->input('gameId'),
            'eventId' => $request->input('eventId'),
            'direction' => $request->input('direction'),
            'transactionId' => $request->input('transactionId'),
            'amount' => $request->input('amount'),
            'amount' => $request->input('amount'),
            'selected' => $request->input('selected'),
            'result' => $request->input('result'),
            'featureGame' => $request->input('featureGame')
        ];

        $responseMoveFunds = (new BridgeApiService)->moveFunds($params);

        if ($responseMoveFunds == false) {
            return json_encode($responseMoveFunds);
        }

        return response()->json($responseMoveFunds);
    }

    public function exit(Request $request)
    {
        $token = $request->input('token');
        $userId = $request->input('userId');
        $gameId = $request->input('gameId');
        $collect = $request->input('collect');
        $test = $request->input('test');

        $responseExit = (new BridgeApiService)->exitGame($token, $userId, $gameId, $collect, $test);
        if ($test === 'true') {
            return $responseExit;
        }

        if ($responseExit === false) {
            return json_encode(false);
        }
        $result = json_decode($responseExit);
        if (!isset($result->status)) {
            return json_encode(false);
        }
        if ($result->status === false) {
            return json_encode(false);
        }

        return response()->json(true);
    }

    /**
     * Метод отправляет запрос на повторную попытку отправки данных
     * с результатами хода
     * @return json
     */
    public function moveFundsRepeat(Request $request)
    {
        $moveFundsExceptionID = $request->input('moveFundsExceptionID');

        $moveFundsExceptionModel = (new MoveFundsExceptionModel())
            ->where('id', '=', $moveFundsExceptionID)
            ->get()
            ->first();

        if ($moveFundsExceptionModel->count < 5) {
            $moveFundsExceptionModel->count += 1;
            $moveFundsExceptionModel->save();

            $responseMoveFunds = (new BridgeApiService())->moveFunds(unserialize($moveFundsExceptionModel->data), 'end_of_spin');
        } else {
            $unserializeData = unserialize($moveFundsExceptionModel->data);
            throw new BetPlacingAbortException($unserializeData['amount'], $unserializeData['extraInfo']['selected']['0']);
        }

        if ($responseMoveFunds === false) {
            return response()->json(false);
        }
        $result = json_decode($responseMoveFunds);
        if (!isset($result->error)) {
            return response()->json(false);
        }
        if ($result->error !== 1004 && $result->status === false) {
            return response()->json(false);
        }

        return response()->json(true);
    }

    /**
     * Метод отправляет запрос на возврат средств пользователю
     * Если метод возвращает false, то js должен отправлять повторные запросы,
     * пока не вернется true
     * @return json
     */
    public function betPlacingAbort(Request $request)
    {
        $betPlacingAbortExceptionID = $request->input('betPlacingAbortExceptionID');

        $betPlacingAbortException = (new BetPlacingAbortExceptionModel())
            ->where('id', '=', $betPlacingAbortExceptionID)
            ->get()
            ->first();

        // отправка события о возврате средств
        $responseMoveFunds = (new BridgeApiService())->moveFunds(array(
            'token' => $betPlacingAbortException->token,
            'userId' => $betPlacingAbortException->userId,
            'gameId' => $betPlacingAbortException->gameId,
            'direction' => 'credit',
            'eventType' => 'BetPlacingAbort',
            'eventID' => $betPlacingAbortException->eventID,
            'amount' => $betPlacingAbortException->amount,
            'extraInfo' => [
                'selected' => [$betPlacingAbortException->selected]
            ]
        ));

        if ($responseMoveFunds === false) {
            return response()->json(false);
        }
        $result = json_decode($responseMoveFunds);
        if (!isset($result->error)) {
            return response()->json(false);
        }
        if ($result->error !== 1006 && $result->status === false) {
            return response()->json(false);
        }

        return response()->json(true);
    }


}
