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
    static public function addUserBalance(
        string $token,
        int $gameId,
        int $userId,
        string $mode
    ): bool
    {
        // получение баланса через апи
        $balance = BridgeApi::getBalance($token, $userId, $gameId);

        // запись баланса в БД
        BridgeBalanceRepository::updateUserBalance($userId, $mode, $balance);

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
    static public function sendStartSpinMoveFunds(
        string $eventId,
        string $token,
        int $userId,
        int $gameId,
        int $linesInGame,
        int $bet
    ): string
    {
        // преобразование ставки из центов в доллары
        $bet /= 100;

        $params = [
            'eventId' => $eventId,
            'transactionId' => Uuid::generate()->string,
            'token' => $token,
            'userId' => $userId,
            'gameId' => $gameId,
            'direction' => 'debit',
            'eventType' => 'BetPlacing',
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
     * @param  string $eventId           [description]
     * @param  string $token             [description]
     * @param  int    $userId            [description]
     * @param  int    $gameId            [description]
     * @param  int    $linesInGame       [description]
     * @param  int    $totalPayoff       [description]
     * @param  array  $table             [description]
     * @param  string $screen            [description]
     * @param  bool   $isDropFeatureGame [description]
     *
     * @return string json
     */
    static public function sendEndSpinMoveFunds(
        string $eventId,
        string $token,
        int $userId,
        int $gameId,
        int $linesInGame,
        int $totalPayoff,
        array $table,
        string $screen,
        bool $isDropFeatureGame
    ): string
    {
        $direction = BridgeTool::getDirectionParametr($totalPayoff);
        $eventType = BridgeTool::getEventTypeParametr($totalPayoff);
        $result = BridgeTool::getResultParametr($table);
        $featureGame = BridgeTool::getFeatureGameParametr(
            $screen,
            $isDropFeatureGame
        );

        // преобразование общего выигрыша из центов в доллары
        $totalPayoff /= 100;

        $params = [
            'eventId' => $eventId,
            'token' => $token,
            'userId' => $userId,
            'gameId' => $gameId,
            'transactionId' => Uuid::generate()->string,
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
}
