<?php

namespace App\Classes\Bridge777Games;

use Ixudra\Curl\Facades\Curl;

class BridgeApi
{
    /**
     * получение баланса через апи
     *
     * @param  string $token    полученный от 777games
     * @param  int    $userId   полученный от 777games
     * @param  int    $gameId   полученный от 777games
     *
     * @return int              баланс в центах
     */
    public static function getBalance(
        string $token,
        int $userId,
        int $gameId
    ): int {
        $responseGetBalance = Curl::to("https://play777games.com/getBalance?token={$token}&userId={$userId}&gameId={$gameId}")
           ->post();

        // получение баланса в долларах
        $dollarBalance = (float) json_decode($responseGetBalance)->balance;

        // получение баланса в центах
        //$centBalance = (int) floor($dollarBalance * 100);
        $centBalance = $dollarBalance * 100;

        return $centBalance;
    }

    /**
     * Отправка запроса типа moveFunds
     *
     * @param  array  $params набора параметров необходимый для запроса
     *
     * @return string json-ответ
     */
    public static function sendMoveFunds(array $params): string
    {
        $requestURL = "https://play777games.com/moveFunds?";
        $requestURL .= http_build_query($params);

        $responseMoveFunds = Curl::to($requestURL)->post();

        return $responseMoveFunds;
    }
}
