<?php

namespace Tests\Games\LifeOfLuxury2\GameTests;

use Tests\TestCase;
use App\Classes\Games\LifeOfLuxury2\Data\LogicData;
use App\Classes\Games\LifeOfLuxury2\GameDirector;
use App\Models\V2Session;


class UserStatisticsTest extends TestCase
{
    /**
     * Проверка работы spin действия с заготовленным значением table
     * Условия: выпадает проигрышь
     * Результат: все результирующие параметры говорят о проигрыше
     */
    public function testStatisticsAfterActions1()
    {
        $check = true;

        // удаление сессии
        $session = V2Session::where('game_id', 2)->where('user_id', 1)->where('mode', 'demo')->get()->first();
        if ($session) {
            $session->delete();
        }

        $requestArray = [
            "game_id" => "2",
            "user_id" => "1",
            "mode" => "demo",
            "action" => "open_game",
            "session_uuid" => "",
            "token" => null
        ];

        $response = (new GameDirector())
            ->build("demo")
            ->executeAction($requestArray);


        $sessionUuid = json_decode($response)->sessionData->sessionUuid;

        // подготовка к выполнению спин действия
        $requestArray = [
            "game_id" => "2",
            "user_id" => "1",
            "mode" => "demo",
            "action" => "spin",
            "session_uuid" => $sessionUuid,
            "token" => null,
            "linesInGame" => "20",
            "lineBet" => "1"
        ];

        //выпадает проигрышь
        $table = [1,2,3,4,5,6,7,8,9,1,2,3,4,5,6];
        $responseJson = (new GameDirector())
            ->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);

        if ($response->statisticsData->winnings !== 0) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnMainGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loss !== 20) {
            $check = false;
        }
        if ($response->statisticsData->lossOnMainGame !== 20) {
            $check = false;
        }
        if ($response->statisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->spinCount !== 1) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCount !== 0) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCount !== 1) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->featureGamesDropped !== 0) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpins != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpins != 100) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->winPercent != 0) {
            $check = false;
        }
        if ($response->statisticsData->winPercentOnMainGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->winPercentOnFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbols !== [0,2,2,2,2,2,2,1,1,1,0]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,2,2,2,2,2,2,1,1,1,0]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,0,0,0,0,0,0,0,0,0,0]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

        $this->assertTrue($check);
    }

    /**
     * Проверка работы spin
     * Условия: выпадают выигрыши по линиям
     * Результат: все результирующие параметры говорят о выигрыше
     */
    public function testStatisticsAfterActions2()
    {
        $check = true;

        // удаление сессии
        $session = V2Session::where('game_id', 2)->where('user_id', 1)->where('mode', 'demo')->get()->first();
        if ($session) {
            $session->delete();
        }

        $requestArray = [
            "game_id" => "2",
            "user_id" => "1",
            "mode" => "demo",
            "action" => "open_game",
            "session_uuid" => "",
            "token" => null
        ];

        $response = (new GameDirector())
            ->build("demo")
            ->executeAction($requestArray);

        $sessionUuid = json_decode($response)->sessionData->sessionUuid;

        // подготовка к выполнению спин действия
        $requestArray = [
            "game_id" => "2",
            "user_id" => "1",
            "mode" => "demo",
            "action" => "spin",
            "session_uuid" => $sessionUuid,
            "token" => null,
            "linesInGame" => "20",
            "lineBet" => "1"
        ];


        //выпадает выигрышь
        $table = [6,5,7,5,9,3,5,9,7,9,4,3,10,9,4]; // 15
        $responseJson = (new GameDirector())
            ->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);

        if ($response->statisticsData->winnings !== 15) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnMainGame !== 15) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loss !== 20) {
            $check = false;
        }
        if ($response->statisticsData->lossOnMainGame !== 20) {
            $check = false;
        }
        if ($response->statisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->spinCount !== 1) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCount !== 1) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCount !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->featureGamesDropped !== 0) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpins != 100) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpins != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->winPercent != 75) {
            $check = false;
        }
        if ($response->statisticsData->winPercentOnMainGame != 75) {
            $check = false;
        }
        if ($response->statisticsData->winPercentOnFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,1,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,1,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbols !== [0,0,0,2,2,3,1,2,0,4,1]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,0,0,2,2,3,1,2,0,4,1]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,0,0,0,0,0,0,0,0,0,0]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }



        $table = [2,5,6,5,2,6,4,6,7,2,1,8,10,3,7]; // 10
        $responseJson = (new GameDirector())
            ->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);

        if ($response->statisticsData->winnings !== 25) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnMainGame !== 25) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loss !== 40) {
            $check = false;
        }
        if ($response->statisticsData->lossOnMainGame !== 40) {
            $check = false;
        }
        if ($response->statisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->spinCount !== 2) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInMainGame !== 2) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCount !== 2) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInMainGame !== 2) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCount !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->featureGamesDropped !== 0) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpins != 100) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpins != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->winPercent != 62.5) {
            $check = false;
        }
        if ($response->statisticsData->winPercentOnMainGame != 62.5) {
            $check = false;
        }
        if ($response->statisticsData->winPercentOnFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,1,0,0],[0,0,0,1,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,1,0,0],[0,0,0,1,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbols !== [0,1,3,3,3,5,4,4,1,4,2]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,1,3,3,3,5,4,4,1,4,2]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,0,0,0,0,0,0,0,0,0,0]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

        $table = [3,4,5,6,5,8,8,5,4,2,5,1,5,1,7]; // 75
        $responseJson = (new GameDirector())
            ->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);

        if ($response->statisticsData->winnings !== 100) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnMainGame !== 100) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loss !== 60) {
            $check = false;
        }
        if ($response->statisticsData->lossOnMainGame !== 60) {
            $check = false;
        }
        if ($response->statisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->spinCount !== 3) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInMainGame !== 3) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCount !== 3) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInMainGame !== 3) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCount !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->featureGamesDropped !== 0) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpins != 100) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpins != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ((int) $response->statisticsData->winPercent != 166) {
            $check = false;
        }
        if ((int) $response->statisticsData->winPercentOnMainGame != 166) {
            $check = false;
        }
        if ($response->statisticsData->winPercentOnFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,1,1,0],[0,0,0,1,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,1,1,0],[0,0,0,1,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbols !== [0,3,4,4,5,10,5,5,3,4,2]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,3,4,4,5,10,5,5,3,4,2]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,0,0,0,0,0,0,0,0,0,0]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

        $table = [2,4,7,8,7,0,8,3,0,6,4,5,8,4,3]; // 60
        $responseJson = (new GameDirector())
            ->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);

        if ($response->statisticsData->winnings !== 160) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnMainGame !== 160) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loss !== 80) {
            $check = false;
        }
        if ($response->statisticsData->lossOnMainGame !== 80) {
            $check = false;
        }
        if ($response->statisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->spinCount !== 4) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInMainGame !== 4) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCount !== 4) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInMainGame !== 4) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCount !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->featureGamesDropped !== 0) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpins != 100) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpins != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ((int) $response->statisticsData->winPercent != 200) {
            $check = false;
        }
        if ((int) $response->statisticsData->winPercentOnMainGame != 200) {
            $check = false;
        }
        if ($response->statisticsData->winPercentOnFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,1,0,0],[0,0,0,1,1,0],[0,0,0,1,0,0],[0,0,0,2,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,1,0,0],[0,0,0,1,1,0],[0,0,0,1,0,0],[0,0,0,2,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbols !== [2,3,5,6,8,11,6,7,6,4,2]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== [2,3,5,6,8,11,6,7,6,4,2]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,0,0,0,0,0,0,0,0,0,0]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

        $this->assertTrue($check);
    }

    /**
     * Проверка работы free_spin в demo режиме
     * Условия: выпадают выигрыши по линиям
     * Результат: выполняются фриспины с обычными выигрышами по линиям
     */
    public function testStatisticsAfterActions3()
    {
        $check = true;

        // удаление сессии
        $session = V2Session::where('game_id', 2)->where('user_id', 1)->where('mode', 'demo')->get()->first();
        if ($session) {
            $session->delete();
        }

        $game = $this->getGame();
        $dataPool = $game->dataPool;
        $workersPool = $game->workersPool;
        $toolsPool = $game->toolsPool;
        $requestDataSets = $game->requestDataSets;

        $requestArray = [
            "game_id" => "2",
            "user_id" => "1",
            "mode" => "demo",
            "action" => "open_game",
            "session_uuid" => "",
            "token" => null
        ];

        $response = (new GameDirector())
            ->build("demo")
            ->executeAction($requestArray);

        $sessionUuid = json_decode($response)->sessionData->sessionUuid;
        $balance = json_decode($response)->balanceData->balance;

        // подготовка к выполнению спин действия
        $requestArray = [
            "game_id" => "2",
            "user_id" => "1",
            "mode" => "demo",
            "action" => "spin",
            "session_uuid" => $sessionUuid,
            "token" => null,
            "linesInGame" => "20",
            "lineBet" => "1"
        ];

        //выпадает проигрышь
        $table = [1,2,3,4,5,6,7,8,9,1,2,3,4,5,6];
        $responseJson = (new GameDirector())
            ->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);

        if ($response->statisticsData->winnings !== 0) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnMainGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loss !== 20) {
            $check = false;
        }
        if ($response->statisticsData->lossOnMainGame !== 20) {
            $check = false;
        }
        if ($response->statisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->spinCount !== 1) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCount !== 0) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCount !== 1) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->featureGamesDropped !== 0) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpins != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpins != 100) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->winPercent != 0) {
            $check = false;
        }
        if ($response->statisticsData->winPercentOnMainGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->winPercentOnFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbols !== [0,2,2,2,2,2,2,1,1,1,0]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,2,2,2,2,2,2,1,1,1,0]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,0,0,0,0,0,0,0,0,0,0]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }



        //выпадают фриспины
        $table = [10,2,3,4,5,6,7,8,9,10,2,3,0,5,2]; // 80
        $responseJson = (new GameDirector())
            ->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);

        if ($response->statisticsData->winnings !== 80) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnMainGame !== 80) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loss !== 40) {
            $check = false;
        }
        if ($response->statisticsData->lossOnMainGame !== 40) {
            $check = false;
        }
        if ($response->statisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->spinCount !== 2) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInMainGame !== 2) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCount !== 1) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCount !== 1) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->featureGamesDropped !== 1) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpins != 50) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInMainGame != 50) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpins != 50) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInMainGame != 50) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->winPercent != 200) {
            $check = false;
        }
        if ($response->statisticsData->winPercentOnMainGame != 200) {
            $check = false;
        }
        if ($response->statisticsData->winPercentOnFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbols !== [1,2,5,4,3,4,3,2,2,2,2]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== [1,2,5,4,3,4,3,2,2,2,2]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,0,0,0,0,0,0,0,0,0,0]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,1,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }



        // подготовка к выполнению freespin действия
        $requestArray = [
            "game_id" => "2",
            "user_id" => "1",
            "mode" => "demo",
            "action" => "free_spin",
            "session_uuid" => $sessionUuid,
            "token" => null,
            "linesInGame" => "20",
            "lineBet" => "1"
        ];

        //фриспин
        $table = [2,1,3,5,1,6,7,8,9,4,2,3,4,5,6]; // 60
        $responseJson = (new GameDirector())
            ->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);

        if ($response->statisticsData->winnings !== 140) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnMainGame !== 80) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnFeatureGame !== 60) {
            $check = false;
        }
        if ($response->statisticsData->loss !== 40) {
            $check = false;
        }
        if ($response->statisticsData->lossOnMainGame !== 40) {
            $check = false;
        }
        if ($response->statisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->spinCount !== 3) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInMainGame !== 2) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInFeatureGame !== 1) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCount !== 2) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInFeatureGame !== 1) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCount !== 1) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->featureGamesDropped !== 1) {
            $check = false;
        }
        if ((int) $response->statisticsData->percentWinSpins != 66) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInMainGame != 50) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInFeatureGame != 100) {
            $check = false;
        }
        if ((int) $response->statisticsData->percentLoseSpins != 33) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInMainGame != 50) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->winPercent != 350) {
            $check = false;
        }
        if ($response->statisticsData->winPercentOnMainGame != 200) {
            $check = false;
        }
        if ($response->statisticsData->winPercentOnFeatureGame != 150) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbols !== [1,4,7,6,5,6,5,3,3,3,2]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== [1,2,5,4,3,4,3,2,2,2,2]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,2,2,2,2,2,2,1,1,1,0]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,1,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }


        // выполение оставшихся аналогичных ходов в цикле
        for ($i=0; $i < 11; $i++) {
            $responseJson = (new GameDirector())
                ->build("demo")
                ->executeAction($requestArray, $table);
        }
        $response = json_decode($responseJson);

        if ($response->statisticsData->winnings !== 140+660) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnMainGame !== 80) {
            $check = false;
        }
        if ($response->statisticsData->winningsOnFeatureGame !== 60+660) {
            $check = false;
        }
        if ($response->statisticsData->loss !== 40) {
            $check = false;
        }
        if ($response->statisticsData->lossOnMainGame !== 40) {
            $check = false;
        }
        if ($response->statisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->spinCount !== 3+11) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInMainGame !== 2) {
            $check = false;
        }
        if ($response->statisticsData->spinCountInFeatureGame !== 1+11) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCount !== 2+11) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->statisticsData->winSpinCountInFeatureGame !== 1+11) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCount !== 1) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->statisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->statisticsData->featureGamesDropped !== 1) {
            $check = false;
        }
        if ((string) $response->statisticsData->percentWinSpins != (string) 92.857142857143) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInMainGame != 50) {
            $check = false;
        }
        if ($response->statisticsData->percentWinSpinsInFeatureGame != 100) {
            $check = false;
        }
        if ((string) $response->statisticsData->percentLoseSpins != (string) 7.1428571428571) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInMainGame != 50) {
            $check = false;
        }
        if ($response->statisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->statisticsData->winPercent != 2000) {
            $check = false;
        }
        if ($response->statisticsData->winPercentOnMainGame != 200) {
            $check = false;
        }
        if ($response->statisticsData->winPercentOnFeatureGame != 1800) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,3*12,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,3*12,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbols !== [1,26,29,28,27,28,27,14,14,14,2]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== [1,2,5,4,3,4,3,2,2,2,2]) {
            $check = false;
        }
        if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,24,24,24,24,24,24,12,12,12,0]) {
            $check = false;
        }
        if ($response->statisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,1,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

        $this->assertTrue($check);
    }

    // /**
    //  * Проверка работы free_spin в demo режиме
    //  * Условия: выпадают выигрыши по линиям с алмазом на каждом ходу
    //  * Результат: прокуручиваются 12 фриспинов
    //  */
    // public function testStatisticsAfterActions4()
    // {
    //     $check = false;
    //
    //     // удаление сессии
    //     $session = V2Session::where('game_id', 2)->where('user_id', 1)->where('mode', 'demo')->get()->first();
    //     if ($session) {
    //         $session->delete();
    //     }
    //
    //     $game = $this->getGame();
    //     $dataPool = $game->dataPool;
    //     $workersPool = $game->workersPool;
    //     $toolsPool = $game->toolsPool;
    //     $requestDataSets = $game->requestDataSets;
    //
    //     // открытие игры
    //     $requestArray = [
    //         "game_id" => "2",
    //         "user_id" => "1",
    //         "mode" => "demo",
    //         "action" => "open_game",
    //         "session_uuid" => "",
    //         "token" => null
    //     ];
    //
    //     $response = (new GameDirector())
    //         ->build("demo")
    //         ->executeAction($requestArray);
    //
    //     $sessionUuid = json_decode($response)->sessionData->sessionUuid;
    //     $balance = json_decode($response)->balanceData->balance;
    //
    //     // подготовка к выполнению спин действия
    //     $requestArray = [
    //         "game_id" => "2",
    //         "user_id" => "1",
    //         "mode" => "demo",
    //         "action" => "spin",
    //         "session_uuid" => $sessionUuid,
    //         "token" => null,
    //         "linesInGame" => "20",
    //         "lineBet" => "1"
    //     ];
    //
    //
    //     //выпадают фриспины
    //     $table = [10,2,3,4,5,6,7,8,9,10,2,3,10,5,2];
    //     $responseJson = (new GameDirector())
    //         ->build("demo")
    //         ->executeAction($requestArray, $table);
    //
    //     $response = json_decode($responseJson);
    //     $balance = $balance + 40 - 20;
    //
    //
    //     if ($response->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinBonusCombinations !== ) {
    //         $check = false;
    //     }
    //
    //     // подготовка к выполнению спин действия
    //     $requestArray = [
    //         "game_id" => "2",
    //         "user_id" => "1",
    //         "mode" => "demo",
    //         "action" => "free_spin",
    //         "session_uuid" => $sessionUuid,
    //         "token" => null,
    //         "linesInGame" => "20",
    //         "lineBet" => "1"
    //     ];
    //
    //     //фриспин
    //     $table = [2,1,3,5,0,6,7,8,9,4,2,3,4,5,6];
    //     $responseJson = (new GameDirector())
    //         ->build("demo")
    //         ->executeAction($requestArray, $table);
    //
    //     $response = json_decode($responseJson);
    //     $balance = $balance + 120;
    //
    //     if ($response->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinBonusCombinations !== ) {
    //         $check = false;
    //     }
    //
    //     // выполение оставшихся аналогичных ходов в цикле
    //     for ($i=0; $i < 11; $i++) {
    //         $responseJson = (new GameDirector())
    //             ->build("demo")
    //             ->executeAction($requestArray, $table);
    //     }
    //     $response = json_decode($responseJson);
    //
    //     $balance = $balance + 5280;
    //
    //     if ($response->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinBonusCombinations !== ) {
    //         $check = false;
    //     }
    //
    //     $this->assertTrue($check);
    // }
    //
    // /**
    //  * Проверка работы free_spin в demo режиме
    //  * Условия: выпадают фриспинов в фриспинах
    //  * Результат: прокуручиваются 36 фриспинов
    //  */
    // public function testStatisticsAfterActions5()
    // {
    //     $check = false;
    //
    //     // удаление сессии
    //     $session = V2Session::where('game_id', 2)->where('user_id', 1)->where('mode', 'demo')->get()->first();
    //     if ($session) {
    //         $session->delete();
    //     }
    //
    //     $game = $this->getGame();
    //     $dataPool = $game->dataPool;
    //     $workersPool = $game->workersPool;
    //     $toolsPool = $game->toolsPool;
    //     $requestDataSets = $game->requestDataSets;
    //
    //     // открытие игры
    //     $requestArray = [
    //         "game_id" => "2",
    //         "user_id" => "1",
    //         "mode" => "demo",
    //         "action" => "open_game",
    //         "session_uuid" => "",
    //         "token" => null
    //     ];
    //
    //     $response = (new GameDirector)->build("demo")
    //         ->executeAction($requestArray);
    //
    //
    //     $sessionUuid = json_decode($response)->sessionData->sessionUuid;
    //     $balance = json_decode($response)->balanceData->balance;
    //
    //     // подготовка к выполнению спин действия
    //     $requestArray = [
    //         "game_id" => "2",
    //         "user_id" => "1",
    //         "mode" => "demo",
    //         "action" => "spin",
    //         "session_uuid" => $sessionUuid,
    //         "token" => null,
    //         "linesInGame" => "20",
    //         "lineBet" => "1"
    //     ];
    //
    //
    //     //выпадают фриспины
    //     $table = [10,2,3,4,5,6,7,8,9,10,2,3,10,5,2];
    //     $responseJson = (new GameDirector)->build("demo")
    //         ->executeAction($requestArray, $table);
    //
    //     $response = json_decode($responseJson);
    //     $balance = $balance + 40 - 20;
    //
    //     if ($response->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinBonusCombinations !== ) {
    //         $check = false;
    //     }
    //
    //     // подготовка к выполнению спин действия
    //     $requestArray = [
    //         "game_id" => "2",
    //         "user_id" => "1",
    //         "mode" => "demo",
    //         "action" => "free_spin",
    //         "session_uuid" => $sessionUuid,
    //         "token" => null,
    //         "linesInGame" => "20",
    //         "lineBet" => "1"
    //     ];
    //
    //     //фриспин
    //     $table = [2,1,3,5,1,6,7,8,9,4,2,3,4,5,6];
    //     $responseJson = (new GameDirector)->build("demo")
    //         ->executeAction($requestArray, $table);
    //
    //     $response = json_decode($responseJson);
    //     $balance = $balance + 60;
    //
    //     if ($response->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinBonusCombinations !== ) {
    //         $check = false;
    //     }
    //
    //     // подготовка к выпадению featureGame в featureGame
    //     $requestArray = [
    //         "game_id" => "2",
    //         "user_id" => "1",
    //         "mode" => "demo",
    //         "action" => "free_spin",
    //         "session_uuid" => $sessionUuid,
    //         "token" => null,
    //         "linesInGame" => "20",
    //         "lineBet" => "1"
    //     ];
    //
    //     //фриспин с выпадением featureGame
    //     $table = [10,2,3,10,5,6,0,8,9,1,2,3,4,5,6];
    //     $responseJson = (new GameDirector)->build("demo")
    //         ->executeAction($requestArray, $table);
    //
    //     $response = json_decode($responseJson);
    //     $balance = $balance + 160;
    //
    //
    //
    //     if ($response->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinBonusCombinations !== ) {
    //         $check = false;
    //     }
    //
    //     $table = [1,2,3,4,5,6,7,8,9,1,2,3,4,5,6];
    //     // выполение оставшихся ходов, кроме последего
    //     for ($i=0; $i < 21; $i++) {
    //         $responseJson = (new GameDirector)->build("demo")
    //             ->executeAction($requestArray, $table);
    //     }
    //     $response = json_decode($responseJson);
    //
    //     $balance = $balance;
    //
    //     if ($response->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinBonusCombinations !== ) {
    //         $check = false;
    //     }
    //
    //     //фриспин с выпадением featureGame
    //     $table = [10,2,3,10,5,6,0,8,9,1,2,3,4,5,6];
    //     $responseJson = (new GameDirector)->build("demo")
    //         ->executeAction($requestArray, $table);
    //
    //     $response = json_decode($responseJson);
    //     $balance = $balance + 240;
    //
    //     if ($response->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinBonusCombinations !== ) {
    //         $check = false;
    //     }
    //
    //     $table = [1,2,3,4,5,6,7,8,9,1,2,3,4,5,6];
    //     // выполение оставшихся ходов
    //     for ($i = 24; $i < 36; $i++) {
    //         $responseJson = (new GameDirector)->build("demo")
    //             ->executeAction($requestArray, $table);
    //     }
    //     $response = json_decode($responseJson);
    //
    //     $balance = $balance;
    //
    //     if ($response->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinBonusCombinations !== ) {
    //         $check = false;
    //     }
    //
    //     // подготовка к выполнению спин действия
    //     $requestArray = [
    //         "game_id" => "2",
    //         "user_id" => "1",
    //         "mode" => "demo",
    //         "action" => "spin",
    //         "session_uuid" => $sessionUuid,
    //         "token" => null,
    //         "linesInGame" => "20",
    //         "lineBet" => "1"
    //     ];
    //
    //
    //     //выпадают выигрышь в основной игре
    //     $table = [2,1,3,5,0,6,7,8,9,4,2,3,4,5,6];
    //     $responseJson = (new GameDirector)->build("demo")
    //         ->executeAction($requestArray, $table);
    //
    //     $response = json_decode($responseJson);
    //     $balance = $balance + 60 - 20;
    //
    //     if ($response->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($response->statisticsData->statisticOfWinBonusCombinations !== ) {
    //         $check = false;
    //     }
    //
    //     $this->assertTrue($check);
    // }
}
