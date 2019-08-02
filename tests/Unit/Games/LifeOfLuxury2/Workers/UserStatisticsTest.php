<?php

namespace Tests\Games\LifeOfLuxury2\GameTests;

use Tests\TestCase;
use App\Classes\Games\LifeOfLuxury2\Data\LogicData;
use App\Classes\Games\LifeOfLuxury2\GameDirector;
use App\Models\V2Session;
use App\Models\V2UserStatistic;


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
        $session = V2UserStatistic::where('game_id', 2)->where('user_id', 1)->where('mode', 'demo')->get()->first();
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

        if ($response->userStatisticsData->winnings !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpins != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpins != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercent != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnMainGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [0,2,2,2,2,2,2,1,1,1,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,2,2,2,2,2,2,1,1,1,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,0,0,0,0,0,0,0,0,0,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
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
        $session = V2UserStatistic::where('game_id', 2)->where('user_id', 1)->where('mode', 'demo')->get()->first();
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

        if ($response->userStatisticsData->winnings !== 15) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 15) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpins != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpins != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercent != 75) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnMainGame != 75) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,1,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,1,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [0,0,0,2,2,3,1,2,0,4,1]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,0,0,2,2,3,1,2,0,4,1]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,0,0,0,0,0,0,0,0,0,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }



        $table = [2,5,6,5,2,6,4,6,7,2,1,8,10,3,7]; // 10
        $responseJson = (new GameDirector())
            ->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);

        if ($response->userStatisticsData->winnings !== 25) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 25) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpins != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpins != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercent != 62.5) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnMainGame != 62.5) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,1,0,0],[0,0,0,1,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,1,0,0],[0,0,0,1,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [0,1,3,3,3,5,4,4,1,4,2]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,1,3,3,3,5,4,4,1,4,2]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,0,0,0,0,0,0,0,0,0,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

        $table = [3,4,5,6,5,8,8,5,4,2,5,1,5,1,7]; // 75
        $responseJson = (new GameDirector())
            ->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);

        if ($response->userStatisticsData->winnings !== 100) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 100) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 60) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 60) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 3) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 3) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 3) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 3) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpins != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpins != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ((int) $response->userStatisticsData->winPercent != 166) {
            $check = false;
        }
        if ((int) $response->userStatisticsData->winPercentOnMainGame != 166) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,1,1,0],[0,0,0,1,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,1,1,0],[0,0,0,1,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [0,3,4,4,5,10,5,5,3,4,2]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,3,4,4,5,10,5,5,3,4,2]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,0,0,0,0,0,0,0,0,0,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

        $table = [2,4,7,8,7,0,8,3,0,6,4,5,8,4,3]; // 60
        $responseJson = (new GameDirector())
            ->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);

        if ($response->userStatisticsData->winnings !== 160) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 160) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 80) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 80) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 4) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 4) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 4) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 4) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpins != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpins != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ((int) $response->userStatisticsData->winPercent != 200) {
            $check = false;
        }
        if ((int) $response->userStatisticsData->winPercentOnMainGame != 200) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,1,0,0],[0,0,0,1,1,0],[0,0,0,1,0,0],[0,0,0,2,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,1,0,0],[0,0,0,1,1,0],[0,0,0,1,0,0],[0,0,0,2,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [2,3,5,6,8,11,6,7,6,4,2]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [2,3,5,6,8,11,6,7,6,4,2]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,0,0,0,0,0,0,0,0,0,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
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
        $session = V2UserStatistic::where('game_id', 2)->where('user_id', 1)->where('mode', 'demo')->get()->first();
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

        if ($response->userStatisticsData->winnings !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpins != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpins != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercent != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnMainGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [0,2,2,2,2,2,2,1,1,1,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,2,2,2,2,2,2,1,1,1,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,0,0,0,0,0,0,0,0,0,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }



        //выпадают фриспины
        $table = [10,2,3,4,5,6,7,8,9,10,2,3,0,5,2]; // 80
        $responseJson = (new GameDirector())
            ->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);

        if ($response->userStatisticsData->winnings !== 80) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 80) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpins != 50) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 50) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpins != 50) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 50) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercent != 200) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnMainGame != 200) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [1,2,5,4,3,4,3,2,2,2,2]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [1,2,5,4,3,4,3,2,2,2,2]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,0,0,0,0,0,0,0,0,0,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,1,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
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

        if ($response->userStatisticsData->winnings !== 140) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 80) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 60) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 3) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 1) {
            $check = false;
        }
        if ((int) $response->userStatisticsData->percentWinSpins != 66) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 50) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInFeatureGame != 100) {
            $check = false;
        }
        if ((int) $response->userStatisticsData->percentLoseSpins != 33) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 50) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercent != 350) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnMainGame != 200) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 150) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [1,4,7,6,5,6,5,3,3,3,2]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [1,2,5,4,3,4,3,2,2,2,2]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,2,2,2,2,2,2,1,1,1,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,1,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }


        // выполение оставшихся аналогичных ходов в цикле
        for ($i=0; $i < 11; $i++) {
            $responseJson = (new GameDirector())
                ->build("demo")
                ->executeAction($requestArray, $table);
        }
        $response = json_decode($responseJson);

        if ($response->userStatisticsData->winnings !== 140+660) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 80) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 60+660) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 3+11) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 1+11) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 2+11) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 1+11) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 1) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentWinSpins != (string) 92.857142857143) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 50) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInFeatureGame != 100) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentLoseSpins != (string) 7.1428571428571) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 50) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercent != 2000) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnMainGame != 200) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 1800) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,3*12,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,3*12,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [1,26,29,28,27,28,27,14,14,14,2]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [1,2,5,4,3,4,3,2,2,2,2]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,24,24,24,24,24,24,12,12,12,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,1,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

        $this->assertTrue($check);
    }

    /**
     * Проверка работы free_spin в demo режиме
     * Условия: выпадают выигрыши по линиям с алмазом на каждом ходу
     * Результат: прокуручиваются 12 фриспинов
     */
    public function testStatisticsAfterActions4()
    {
        $check = true;

        // удаление сессии
        $session = V2Session::where('game_id', 2)->where('user_id', 1)->where('mode', 'demo')->get()->first();
        if ($session) {
            $session->delete();
        }
        $session = V2UserStatistic::where('game_id', 2)->where('user_id', 1)->where('mode', 'demo')->get()->first();
        if ($session) {
            $session->delete();
        }

        $game = $this->getGame();
        $dataPool = $game->dataPool;
        $workersPool = $game->workersPool;
        $toolsPool = $game->toolsPool;
        $requestDataSets = $game->requestDataSets;

        // открытие игры
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


        //выпадают фриспины
        $table = [10,2,3,4,5,6,7,8,9,10,2,3,10,5,2];
        $responseJson = (new GameDirector())
            ->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);

        if ($response->userStatisticsData->winnings !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 1) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentWinSpins != (string) 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentLoseSpins != (string) 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercent != 200) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnMainGame != 200) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [0,0,3,2,1,2,1,1,1,1,3]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,0,3,2,1,2,1,1,1,1,3]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,0,0,0,0,0,0,0,0,0,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[1,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

        // подготовка к выполнению спин действия
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
        $table = [2,1,3,5,0,6,7,8,9,4,2,3,4,5,6];
        $responseJson = (new GameDirector())
            ->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);

        if ($response->userStatisticsData->winnings !== 160) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 120) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 1) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentWinSpins != (string) 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInFeatureGame != 100) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentLoseSpins != (string) 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercent != 800) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnMainGame != 200) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 600) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [1,1,5,4,3,4,3,2,2,2,3]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,0,3,2,1,2,1,1,1,1,3]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [1,1,2,2,2,2,2,1,1,1,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[1,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

        // выполение оставшихся аналогичных ходов в цикле
        for ($i=0; $i < 11; $i++) {
            $responseJson = (new GameDirector())
                ->build("demo")
                ->executeAction($requestArray, $table);
        }
        $response = json_decode($responseJson);

        if ($response->userStatisticsData->winnings !== 5440) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 5400) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 13) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 12) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 13) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 12) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 1) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentWinSpins != (string) 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInFeatureGame != 100) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentLoseSpins != (string) 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercent != 27200) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnMainGame != 200) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 27000) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,36,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,36,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [12,12,27,26,25,26,25,13,13,13,3]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,0,3,2,1,2,1,1,1,1,3]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [12,12,24,24,24,24,24,12,12,12,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[1,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

        $this->assertTrue($check);
    }

    /**
     * Проверка работы free_spin в demo режиме
     * Условия: выпадают фриспинов в фриспинах
     * Результат: прокуручиваются 36 фриспинов
     */
    public function testStatisticsAfterActions5()
    {
        $check = true;

        // удаление сессии
        $session = V2Session::where('game_id', 2)->where('user_id', 1)->where('mode', 'demo')->get()->first();
        if ($session) {
            $session->delete();
        }
        $session = V2UserStatistic::where('game_id', 2)->where('user_id', 1)->where('mode', 'demo')->get()->first();
        if ($session) {
            $session->delete();
        }

        $game = $this->getGame();
        $dataPool = $game->dataPool;
        $workersPool = $game->workersPool;
        $toolsPool = $game->toolsPool;
        $requestDataSets = $game->requestDataSets;

        // открытие игры
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

        //выпадают фриспины
        $table = [10,2,3,4,5,6,7,8,9,10,2,3,10,5,2];
        $responseJson = (new GameDirector)->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);

        if ($response->userStatisticsData->winnings !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 1) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentWinSpins != (string) 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentLoseSpins != (string) 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercent != 200) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnMainGame != 200) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [0,0,3,2,1,2,1,1,1,1,3]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,0,3,2,1,2,1,1,1,1,3]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,0,0,0,0,0,0,0,0,0,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[1,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }


        // подготовка к выполнению спин действия
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
        $table = [2,1,3,5,1,6,7,8,9,4,2,3,4,5,6];
        $responseJson = (new GameDirector)->build("demo")
            ->executeAction($requestArray, $table);

        //dd(__METHOD__, 1213123);

        $response = json_decode($responseJson);
        $balance = $balance + 60;

        if ($response->userStatisticsData->winnings !== 100) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 60) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 1) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentWinSpins != (string) 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInFeatureGame != 100) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentLoseSpins != (string) 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercent != 500) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnMainGame != 200) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 300) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [0,2,5,4,3,4,3,2,2,2,3]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,0,3,2,1,2,1,1,1,1,3]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,2,2,2,2,2,2,1,1,1,0]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[1,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

        // подготовка к выпадению featureGame в featureGame
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

        //фриспин с выпадением featureGame
        $table = [10,2,3,10,5,6,0,8,9,1,2,3,4,5,6];
        $responseJson = (new GameDirector)->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);
        $balance = $balance + 160;

        if ($response->userStatisticsData->winnings !== 260) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 220) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 3) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 3) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 1) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentWinSpins != (string) 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInFeatureGame != 100) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentLoseSpins != (string) 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercent != 1300) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnMainGame != 200) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 1100) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [1,3,7,6,4,6,5,2,3,3,5]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,0,3,2,1,2,1,1,1,1,3]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [1,3,4,4,3,4,4,1,2,2,2]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[1,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

        $table = [1,2,3,4,5,6,7,8,9,1,2,3,4,5,6];
        // выполение оставшихся ходов, кроме последего
        for ($i=0; $i < 21; $i++) {
            $responseJson = (new GameDirector)->build("demo")
                ->executeAction($requestArray, $table);
        }
        $response = json_decode($responseJson);

        $balance = $balance;

        if ($response->userStatisticsData->winnings !== 260) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 220) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 24) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 23) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 3) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 21) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 21) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 1) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentWinSpins != (string) 12.5) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentWinSpinsInFeatureGame != (string) '8.695652173913') {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentLoseSpins != (string) 87.5) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentLoseSpinsInFeatureGame != (string) '91.304347826087') {
            $check = false;
        }
        if ($response->userStatisticsData->winPercent != 1300) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnMainGame != 200) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 1100) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [1,45,49,48,46,48,47,23,24,24,5]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,0,3,2,1,2,1,1,1,1,3]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [1,45,46,46,45,46,46,22,23,23,2]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[1,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

        //фриспин с выпадением featureGame
        $table = [10,2,3,10,5,6,0,8,9,1,2,3,4,5,6];
        $responseJson = (new GameDirector)->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);
        $balance = $balance + 240;

        if ($response->userStatisticsData->winnings !== 500) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 460) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 25) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 24) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 4) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 3) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 21) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 21) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 1) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentWinSpins != (string) 16) {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentWinSpinsInFeatureGame != (string) '12.5') {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentLoseSpins != (string) 84) {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentLoseSpinsInFeatureGame != (string) '87.5') {
            $check = false;
        }
        if ($response->userStatisticsData->winPercent != 2500) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnMainGame != 200) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 2300) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [2,46,51,50,47,50,49,23,25,25,7]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,0,3,2,1,2,1,1,1,1,3]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [2,46,48,48,46,48,48,22,24,24,4]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[1,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

        $table = [1,2,3,4,5,6,7,8,9,1,2,3,4,5,6];
        // выполение оставшихся ходов
        for ($i = 24; $i < 36; $i++) {
            $responseJson = (new GameDirector)->build("demo")
                ->executeAction($requestArray, $table);
        }
        $response = json_decode($responseJson);

        if ($response->userStatisticsData->winnings !== 500) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 460) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 20) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 37) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 36) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 4) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 3) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 33) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 33) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 1) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentWinSpins != (string) '10.810810810811') {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentWinSpinsInFeatureGame != (string) '8.3333333333333') {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentLoseSpins != (string) '89.189189189189') {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentLoseSpinsInFeatureGame != (string) '91.666666666667') {
            $check = false;
        }
        if ($response->userStatisticsData->winPercent != 2500) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnMainGame != 200) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 2300) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [2,70,75,74,71,74,73,35,37,37,7]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,0,3,2,1,2,1,1,1,1,3]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [2,70,72,72,70,72,72,34,36,36,4]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[1,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

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


        //выпадают выигрышь в основной игре
        $table = [2,1,3,5,0,6,7,8,9,4,2,3,4,5,6];
        $responseJson = (new GameDirector)->build("demo")
            ->executeAction($requestArray, $table);

        $response = json_decode($responseJson);
        $balance = $balance + 60 - 20;

        if ($response->userStatisticsData->winnings !== 560) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnMainGame !== 100) {
            $check = false;
        }
        if ($response->userStatisticsData->winningsOnFeatureGame !== 460) {
            $check = false;
        }
        if ($response->userStatisticsData->loss !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnMainGame !== 40) {
            $check = false;
        }
        if ($response->userStatisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCount !== 38) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInMainGame !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->spinCountInFeatureGame !== 36) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCount !== 5) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInMainGame !== 2) {
            $check = false;
        }
        if ($response->userStatisticsData->winSpinCountInFeatureGame !== 3) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCount !== 33) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($response->userStatisticsData->loseSpinCountInFeatureGame !== 33) {
            $check = false;
        }
        if ($response->userStatisticsData->featureGamesDropped !== 1) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentWinSpins != (string) '13.157894736842') {
            $check = false;
        }
        if ($response->userStatisticsData->percentWinSpinsInMainGame != 100) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentWinSpinsInFeatureGame != (string) '8.3333333333333') {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentLoseSpins != (string) '86.842105263158') {
            $check = false;
        }
        if ($response->userStatisticsData->percentLoseSpinsInMainGame != 0) {
            $check = false;
        }
        if ((string) $response->userStatisticsData->percentLoseSpinsInFeatureGame != (string) '91.666666666667') {
            $check = false;
        }
        if ($response->userStatisticsData->winPercent != 1400) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnMainGame != 250) {
            $check = false;
        }
        if ($response->userStatisticsData->winPercentOnFeatureGame != 1150) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,6,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,3,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbols !== [3,71,77,76,73,76,75,36,38,38,7]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInMainGame !== [1,1,5,4,3,4,3,2,2,2,3]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [2,70,72,72,70,72,72,34,36,36,4]) {
            $check = false;
        }
        if ($response->userStatisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[1,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

        $this->assertTrue($check);
    }
}
