<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Classes\Bridge777Games\BridgeService;
use App\Classes\Bridge777Games\BridgeApi;
use Webpatser\Uuid\Uuid;
use Ixudra\Curl\Facades\Curl;
use App\Models\V2Balance;
use App\Models\V2Session;

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
        $platformId = (int) $request->input('platformId');

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
            'userId' => $request->input('userId'),
            'gameId' => $request->input('gameId'),
            'platformId' => (int) $request->input('platform_id'),
            'transactionId' => Uuid::generate()->string,
            'direction' => 'debit',
            'eventType' => 'BetPlacing',
            'amount' => 0,
            'extraInfo' => [],
            'eventId' => Uuid::generate()->string
        );

        // получение ответа от slot.pantera
        $responseMoveFunds = BridgeApi::sendMoveFunds($requestData);

        return $responseMoveFunds;
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
        $sessionUuid = $request->input('session_uuid');

        $url = 'https://play777games.com/';
        if ($platformId === 2 || $platformId === '2') {
            $url = 'https://play.devbet.live/';
        }

        $responseGetBalance = Curl::to("{$url}getBalance?token={$token}&userId={$userId}&gameId={$gameId}&platformId={$platformId}")
        ->post();

    	$data = json_decode($responseGetBalance);

	$balanceData = V2Balance::where('user_id', $userId)->where('mode', 'full')->first();
	$balanceData->value = $data->balance * 10000 / 100;
	$balanceData->save();

    	return ['status' => 'true', 'balance' => $data->balance * 10000 / 100];
    }

    public function exitGame(Request $request)
    {
        $url = 'https://play777games.com/';

        $token = $request->input('token');
        $userId = $request->input('userId');
        $gameId = $request->input('gameId');
        $collect = $request->input('collect');
        $test = false;

        if ($collect === 'true') {
            $collect = true;
        } elseif ($collect === 'false') {
            $collect = false;
        } else {
            $collect = false;
        }

        $platformId = 1;
        if (isset($_GET['platformId'])) {
            $platformId = (int) $_GET['platformId'];
        }

        if ($platformId === 2 || $platformId === '2') {
            $url = 'https://play.devbet.live/';
        }

        $platformId = 1;
        if (isset($_GET['platformId'])) {
            $platformId = $_GET['platformId'];
        }
        $ch = curl_init( "{$url}exit" );
        $payload = json_encode( array(
          'token' => $token,
          'userId' => $userId,
          'gameId' => $gameId,
          'collect' => $collect,
          'platformId' => $platformId
        ) );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
