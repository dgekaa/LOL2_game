<?php

namespace App\Classes\Bridge777Games;

use App\Classes\Bridge777Games\BridgeApi;
use App\Classes\Bridge777Games\BridgeBalanceRepository;
use App\Classes\Bridge777Games\BridgeTool;
use Webpatser\Uuid\Uuid;

class BridgeService
{
    /**
     * получение и сохранение баланса пользователя
     *
     * @param  string $token
     * @param  int    $gameId
     * @param  int    $userId
     * @param  string $mode
     *
     * @return bool
     */
    public static function addUserBalance(
        string $token,
        int $gameId,
        int $userId,
        string $mode,
        int $platformId
    ): bool {
        // получение баланса через апи
        if ($mode === 'full') {
            $balance = BridgeApi::getBalance($token, $userId, $gameId, $platformId);

            // запись баланса в БД
            BridgeBalanceRepository::updateUserBalance($userId, $mode, $balance);
        } elseif ($mode === 'demo') {
            $balance = 10000;
        }

        return true;
    }

    /**
     * Отправка данных на 777games о начале выполнения хода в основной игре
     *
     * @param  string $eventId     [description]
     * @param  string $token       [description]
     * @param  int    $userId      [description]
     * @param  int    $gameId      [description]
     * @param  int    $linesInGame [description]
     * @param  int    $bet         [description]
     *
     * @return string json
     */
    public static function sendStartSpinMoveFunds(
        string $eventId,
        string $token,
        int $userId,
        int $gameId,
        int $linesInGame,
        int $bet,
        int $platformId
    ): string {
        // преобразование ставки из центов в доллары
        $bet /= 100;

        $transactionId = intval(sprintf("%d%d", $userId, intval(substr(strval(microtime(true)*10000), 3))));

        $params = [
            'eventId' => $eventId,
            'transactionId' => $transactionId,
            'token' => $token,
            'userId' => $userId,
            'gameId' => $gameId,
            'direction' => 'debit',
            'eventType' => 'BetPlacing',
            'platformId' => $platformId,
            'amount' => $bet,
            'extraInfo' => [
                'selected' => [$linesInGame]
            ]
        ];

        $response = BridgeApi::sendMoveFunds($params);

        return $response;
    }

    /**
     * Отрпвка данных с результатими хода в основной игре
     *
     * @param  string $eventId                 [description]
     * @param  string $token                   [description]
     * @param  int    $userId                  [description]
     * @param  int    $gameId                  [description]
     * @param  int    $linesInGame             [description]
     * @param  int    $totalPayoff             [description]
     * @param  array  $table                   [description]
     * @param  int    $platformId              [description]
     * @param  int    $moveNumberInFeatureGame [description]
     * @param  bool   $isEndFeatureGame        [description]
     *
     * @return string json
     */
    public static function sendEndSpinMoveFunds(
        string $eventId,
        string $token,
        int $userId,
        int $gameId,
        int $linesInGame,
        int $totalPayoff,
        array $table,
        int $platformId,
        int $moveNumberInFeatureGame,
        bool $isEndFeatureGame
    ): string {
        $direction = BridgeTool::getDirectionParametr($totalPayoff);
        $eventType = BridgeTool::getEventTypeParametr($totalPayoff);
        $result = BridgeTool::getResultParametr($table);
        $featureGame = BridgeTool::getFeatureGameParametr(
            $moveNumberInFeatureGame,
            $isEndFeatureGame
        );

        // преобразование общего выигрыша из центов в доллары
        $totalPayoff /= 100;

        $transactionId = intval(sprintf("%d%d", $userId, intval(substr(strval(microtime(true)*10000), 3))));

        $params = [
            'eventId' => $eventId,
            'token' => $token,
            'userId' => $userId,
            'gameId' => $gameId,
            'platformId' => $platformId,
            'transactionId' => $transactionId,
            'direction' => 'credit',
            'eventType' => $eventType,
            'amount' => $totalPayoff,
            'extraInfo' => [
                'selected' => [$linesInGame],
                'result' => $result,
                'featureGame' => $featureGame
            ]
        ];

        $response = BridgeApi::sendMoveFunds($params);

        return $response;
    }

    /**
     * Отправка запроса оповещающего об выходе из игры
     *
     * @param  string $token   [description]
     * @param  int    $userId  [description]
     * @param  int    $gameId  [description]
     * @param  string $collect [description]
     *
     * @return string          [description]
     */
    public static function sendCloseGame(
        string $token,
        int $userId,
        int $gameId,
        string $collect,
        int $platformId
    ): string {
        if ($collect === 'true') {
            $collect = true;
        } elseif ($collect === 'false') {
            $collect = false;
        } else {
            $collect = false;
        }

        $url = '';
        if ($platformId === 1) {
            $url = "https://play777games.com/exit";
        } elseif ($platformId === 2) {
            $url = "https://sgdapi.play777games.com/exit";
        } elseif ($platformId === 3) {
            $url = "https://donateandplay.com/exit";
        } elseif ($platformId === 4) {
            $url = "https://old.play777games.com/exit";
        }

        // отправка запроса на 777games
        $ch = curl_init($url);
        $payload = json_encode(array(
              'token' => $token,
              'userId' => $userId,
              'gameId' => $gameId,
              'collect' => $collect,
              'platformId' => $platformId
            ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public static function addCreadit(
        string $token,
        int $userId,
        int $gameId,
        string $eventID,
        int $platformId
    ): string {
        $requestData = array(
            'token' => $_SESSION['token'],
            'userId' => $_SESSION['userId'],
            'gameId' => $_SESSION['gameId'],
            'direction' => 'debit',
            'eventType' => 'BetPlacing',
            'platformId' => $platformId,
            'amount' => 0,
            'extraInfo' => [],
            'eventID' => $eventID
        );

        // получение ответа от slot.pantera
        $responseMoveFunds = BridgeApi::sendMoveFunds($requestData);

        return $responseMoveFunds;
    }
}
