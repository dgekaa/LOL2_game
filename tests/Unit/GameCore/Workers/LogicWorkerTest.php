<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\V2GameRule;

class LogicWorkerTest extends TestCase
{
    /**
     * Проверка работа logicWorker
     * Условия: запрос на выполнение хода
     * Результат: logicWorker делает загрузку данных
     */
    public function testLoadLogicData1()
    {
        $check = true;

        $game = $this->getGame();
        $dataPool = $game->dataPool;
        $workersPool = $game->workersPool;
        $toolsPool = $game->toolsPool;
        $instructionsPool = $game->instructionsPool;

        $dataPool->sessionData->gameId = 1;

        $dataPool = $workersPool->logicWorker->executeInstruction(
            $dataPool,
            $toolsPool,
            $instructionsPool->logicWorkerInstructions->load_data
        );

        if (count($dataPool->logicData->linesRules) === 0) {
            $check = false;
        }
        if (count($dataPool->logicData->combinationsRules) === 0) {
            $check = false;
        }
        if (count($dataPool->logicData->bonusRules) === 0) {
            $check = false;
        }
        if (count($dataPool->logicData->featureGameRules) === 0) {
            $check = false;
        }
        if (count($dataPool->logicData->percentagesRules) === 0) {
            $check = false;
        }

        $this->assertTrue($check);
    }

    /**
     * Проверка работа logicWorker
     * Условия: запрос на выполнение хода
     * Результат: logicWorker генерирует данные результата хода
     */
    public function testGetResultOfSpinForLogicWorker1()
    {
        $check = true;

        $game = $this->getGame();
        $dataPool = $game->dataPool;
        $workersPool = $game->workersPool;
        $toolsPool = $game->toolsPool;
        $instructionsPool = $game->instructionsPool;

        $dataPool->stateData->screen = 'mainGame';
        $dataPool->logicData->linesRules = json_decode(V2GameRule::where('game_id', 1)->where('name', 'lines')->first()->rules);
        $dataPool->logicData->combinationsRules = json_decode(V2GameRule::where('game_id', 1)->where('name', 'winCombinations')->first()->rules);
        $dataPool->logicData->bonusRules = json_decode(V2GameRule::where('game_id', 1)->where('name', 'bonus')->first()->rules);
        $dataPool->logicData->featureGameRules = json_decode(V2GameRule::where('game_id', 1)->where('name', 'featureGame')->first()->rules);
        $dataPool->logicData->percentagesRules = json_decode(V2GameRule::where('game_id', 1)->where('name', 'percentages')->first()->rules);

        $dataPool = $workersPool->logicWorker->executeInstruction(
            $dataPool,
            $toolsPool,
            $instructionsPool->logicWorkerInstructions->spin
        );

        if (count($dataPool->logicData->table) !== 15) {
            $check = false;
        }

        $this->assertTrue($check);
    }

    /**
     * Проверка работа logicWorker
     * Условия: запрос на выполнение freeSpin хода
     * Результат: logicWorker генерирует данные результата хода
     */
    public function testGetResultOfFreeSpinForLogicWorker1()
    {
        $check = true;

        $game = $this->getGame();
        $dataPool = $game->dataPool;
        $workersPool = $game->workersPool;
        $toolsPool = $game->toolsPool;
        $instructionsPool = $game->instructionsPool;

        $dataPool->stateData->screen = 'featureGame';
        $dataPool->logicData->lineBet = 1;
        $dataPool->logicData->linesInGame = 15;
        $dataPool->logicData->linesRules = json_decode(V2GameRule::where('game_id', 1)->where('name', 'lines')->first()->rules);
        $dataPool->logicData->combinationsRules = json_decode(V2GameRule::where('game_id', 1)->where('name', 'winCombinations')->first()->rules);
        $dataPool->logicData->bonusRules = json_decode(V2GameRule::where('game_id', 1)->where('name', 'bonus')->first()->rules);
        $dataPool->logicData->featureGameRules = json_decode(V2GameRule::where('game_id', 1)->where('name', 'featureGame')->first()->rules);
        $dataPool->logicData->percentagesRules = json_decode(V2GameRule::where('game_id', 1)->where('name', 'percentages')->first()->rules);

        $dataPool = $workersPool->logicWorker->executeInstruction(
            $dataPool,
            $toolsPool,
            $instructionsPool->logicWorkerInstructions->free_spin
        );

        if (count($dataPool->logicData->table) !== 15) {
            $check = false;
        }

        $this->assertTrue($check);
    }

}
