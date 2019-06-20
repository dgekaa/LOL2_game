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

        $game = $this->getGame();
        $dataPool = $game->dataPool;
        $workersPool = $game->workersPool;
        $toolsPool = $game->toolsPool;
        $instructionsPool = $game->instructionsPool;
        $requestDataSets = $game->requestDataSets;

        $dataPool->logicData->linesInGame = 20;
        $dataPool->logicData->table = [1,2,3,4,5,6,7,8,9,1,2,3,4,5,6];
        $dataPool->stateData->screen = 'mainGame';
        $dataPool->systemData->isSimulation = true;

        $dataPool = $workersPool->statisticsWorker->getResultOfSpin($dataPool, $toolsPool);

        if ($dataPool->statisticsData->winnings !== 0) {
            $check = false;
        }
        if ($dataPool->statisticsData->winningsOnMainGame !== 0) {
            $check = false;
        }
        if ($dataPool->statisticsData->winningsOnFeatureGame !== 0) {
            $check = false;
        }
        if ($dataPool->statisticsData->loss !== 20) {
            $check = false;
        }
        if ($dataPool->statisticsData->lossOnMainGame !== 20) {
            $check = false;
        }
        if ($dataPool->statisticsData->lossOnFeatureGame !== 0) {
            $check = false;
        }
        if ($dataPool->statisticsData->spinCount !== 1) {
            $check = false;
        }
        if ($dataPool->statisticsData->spinCountInMainGame !== 1) {
            $check = false;
        }
        if ($dataPool->statisticsData->spinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($dataPool->statisticsData->winSpinCount !== 0) {
            $check = false;
        }
        if ($dataPool->statisticsData->winSpinCountInMainGame !== 0) {
            $check = false;
        }
        if ($dataPool->statisticsData->winSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($dataPool->statisticsData->loseSpinCount !== 1) {
            $check = false;
        }
        if ($dataPool->statisticsData->loseSpinCountInMainGame !== 1) {
            $check = false;
        }
        if ($dataPool->statisticsData->loseSpinCountInFeatureGame !== 0) {
            $check = false;
        }
        if ($dataPool->statisticsData->featureGamesDropped !== 0) {
            $check = false;
        }
        if ($dataPool->statisticsData->percentWinSpins != 0) {
            $check = false;
        }
        if ($dataPool->statisticsData->percentWinSpinsInMainGame != 0) {
            $check = false;
        }
        if ($dataPool->statisticsData->percentWinSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($dataPool->statisticsData->percentLoseSpins != 100) {
            $check = false;
        }
        if ($dataPool->statisticsData->percentLoseSpinsInMainGame != 100) {
            $check = false;
        }
        if ($dataPool->statisticsData->percentLoseSpinsInFeatureGame != 0) {
            $check = false;
        }
        if ($dataPool->statisticsData->winPercent != 0) {
            $check = false;
        }
        if ($dataPool->statisticsData->winPercentOnMainGame != 0) {
            $check = false;
        }
        if ($dataPool->statisticsData->winPercentOnFeatureGame != 0) {
            $check = false;
        }
        if ($dataPool->statisticsData->statisticOfWinCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($dataPool->statisticsData->statisticOfWinCombinationsInMainGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($dataPool->statisticsData->statisticOfWinCombinationsInFeatureGame !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }
        if ($dataPool->statisticsData->statisticsOfDroppedSymbols !== [0,2,2,2,2,2,2,1,1,1,0]) {
            $check = false;
        }
        if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInMainGame !== [0,2,2,2,2,2,2,1,1,1,0]) {
            $check = false;
        }
        if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== [0,0,0,0,0,0,0,0,0,0,0]) {
            $check = false;
        }
        if ($dataPool->statisticsData->statisticOfWinBonusCombinations !== [[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]) {
            $check = false;
        }

        $this->assertTrue($check);
    }

    /**
     * Проверка работы spin
     * Условия: выпадают выигрыши по линиям
     * Результат: все результирующие параметры говорят о проигрыше
     */
    // public function testStatisticsAfterActions2()
    // {
    //     $check = false;
    //
    //     $game = $this->getGame();
    //     $dataPool = $game->dataPool;
    //     $workersPool = $game->workersPool;
    //     $toolsPool = $game->toolsPool;
    //     $requestDataSets = $game->requestDataSets;
    //
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
    //     $table = [6,5,7,5,9,3,5,9,7,9,4,3,10,9,4];
    //
    //     $responseJson = (new GameDirector())
    //         ->build("demo")
    //         ->executeAction($requestArray, $table);
    //
    //     $response = json_decode($responseJson);
    //
    //     if ($dataPool->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinBonusCombinations !== ) {
    //         $check = false;
    //     }
    //
    //
    //     $table = [2,5,6,5,2,6,4,6,7,2,1,8,10,3,7];
    //     $responseJson = (new GameDirector())
    //         ->build("demo")
    //         ->executeAction($requestArray, $table);
    //
    //     $response = json_decode($responseJson);
    //
    //     if ($dataPool->statisticsData->screen !== 'mainGame') {
    //         $check = false;
    //     }
    //
    //
    //     $table = [3,4,5,6,5,8,8,5,4,2,5,1,5,1,7];
    //     $responseJson = (new GameDirector())
    //         ->build("demo")
    //         ->executeAction($requestArray, $table);
    //
    //     $response = json_decode($responseJson);
    //
    //     if ($dataPool->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinBonusCombinations !== ) {
    //         $check = false;
    //     }
    //
    //
    //     $table = [2,4,7,8,7,0,8,3,0,6,4,5,8,4,3];
    //     $responseJson = (new GameDirector())
    //         ->build("demo")
    //         ->executeAction($requestArray, $table);
    //
    //     $response = json_decode($responseJson);
    //
    //     if ($dataPool->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinBonusCombinations !== ) {
    //         $check = false;
    //     }
    //
    //     $this->assertTrue($check);
    // }
    //
    // /**
    //  * Проверка работы free_spin в demo режиме
    //  * Условия: выпадают выигрыши по линиям
    //  * Результат: выполняются фриспины с обычными выигрышами по линиям
    //  */
    // public function testStatisticsAfterActions3()
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
    //     if ($dataPool->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinBonusCombinations !== ) {
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
    //     $responseJson = (new GameDirector())
    //         ->build("demo")
    //         ->executeAction($requestArray, $table);
    //
    //     $response = json_decode($responseJson);
    //     $balance = $balance + 60;
    //
    //     if ($dataPool->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinBonusCombinations !== ) {
    //         $check = false;
    //     }
    //
    //
    //     // выполение оставшихся аналогичных ходов в цикле
    //     for ($i=0; $i < 11; $i++) {
    //         $responseJson = (new GameDirector())
    //             ->build("demo")
    //             ->executeAction($requestArray, $table);
    //     }
    //     $response = json_decode($responseJson);
    //
    //     $balance = $balance + 660;
    //
    //     if ($dataPool->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinBonusCombinations !== ) {
    //         $check = false;
    //     }
    //
    //     $this->assertTrue($check);
    // }
    //
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
    //     if ($dataPool->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinBonusCombinations !== ) {
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
    //     if ($dataPool->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinBonusCombinations !== ) {
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
    //     if ($dataPool->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinBonusCombinations !== ) {
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
    //     if ($dataPool->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinBonusCombinations !== ) {
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
    //     if ($dataPool->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinBonusCombinations !== ) {
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
    //     if ($dataPool->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinBonusCombinations !== ) {
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
    //     if ($dataPool->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinBonusCombinations !== ) {
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
    //     if ($dataPool->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinBonusCombinations !== ) {
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
    //     if ($dataPool->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinBonusCombinations !== ) {
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
    //     if ($dataPool->statisticsData->winnings !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winningsOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->loss !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->lossOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCount !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->spinCountInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->featureGamesDropped !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentWinSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpins !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->percentLoseSpinsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->winPercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercent !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->losePercentOnFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinations !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinCombinationsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbols !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInMainGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticsOfDroppedSymbolsInFeatureGame !== ) {
    //         $check = false;
    //     }
    //     if ($dataPool->statisticsData->statisticOfWinBonusCombinations !== ) {
    //         $check = false;
    //     }
    //
    //     $this->assertTrue($check);
    // }
}
