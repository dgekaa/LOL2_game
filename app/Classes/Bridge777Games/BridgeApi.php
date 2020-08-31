<?php

namespace App\Classes\Bridge777Games;

use Illuminate\Support\Facades\Log;
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
        int $gameId,
        int $platformId
    ): int {
        if ($platformId === 1 || $platformId === '1') {
            $responseGetBalance = Curl::to("https://play777games.com/getBalance?token={$token}&userId={$userId}&gameId={$gameId}&platformId={$platformId}")
               ->post();
        } elseif ($platformId === 2 || $platformId === '2') {
            $responseGetBalance = Curl::to("https://play.devbet.live/getBalance?token={$token}&userId={$userId}&gameId={$gameId}&platformId={$platformId}")
               ->post();
        } elseif ($platformId === 3 || $platformId === '3') {
            $responseGetBalance = Curl::to("https://donateandplay.com/getBalance?token={$token}&userId={$userId}&gameId={$gameId}&platformId={$platformId}")
               ->post();
        }

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
        if ($params['platformId'] === 2 || $params['platformId'] === '2') {
            $requestURL = "https://play.devbet.live/moveFunds?";
        }
        if ($params['platformId'] === 3 || $params['platformId'] === 3) {
            $requestURL = "https://donateandplay.com/moveFunds?";
        }
        $requestURL .= http_build_query($params);

        $responseMoveFunds = Curl::to($requestURL)->post();

        self::writeApiLog("moveFunds {$params['eventType']}", ['request' => $requestURL, 'response' => $responseMoveFunds]);

        if ($params['eventType'] === 'BetPlacing') {
            if ($responseMoveFunds === false) {
                throw new \Exception(['type' => 'bridgeApi->moveFunds', 'requestURL' => $requestURL, 'responseMoveFunds' => $responseMoveFunds]);
            }
            if (!isset(json_decode($responseMoveFunds)->status)) {
                throw new \Exception(['type' => 'bridgeApi->moveFunds', 'requestURL' => $requestURL, 'responseMoveFunds' => $responseMoveFunds]);
            }
            if (json_decode($responseMoveFunds)->status === false) {
                throw new \Exception(['type' => 'bridgeApi->moveFunds', 'requestURL' => $requestURL, 'responseMoveFunds' => $responseMoveFunds]);
            }
        }

        return $responseMoveFunds;
    }

    /**
     * @param string $message
     * @param array $context
     */
    private static function writeApiLog(string $message, array $context) {
        Log::channel('api')->info($message, $context);
    }
}
