<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getGame()
    {
        $game = (new \Avior\GameCore\GameDirector)->build('demo');

        return $game;
    }

    protected function loadStartData($dataPool, $workersPool, $toolsPool, $instructionsPool)
    {
        $dataPool = $workersPool->sessionWorker->loadSessionData($dataPool, $toolsPool);
        // загрузка баланса
        $dataPool = $workersPool->balanceWorker->loadBalanceData($dataPool, $toolsPool);
        // загрузка логики
        $dataPool = $workersPool->logicWorker->executeInstruction(
            $dataPool,
            $toolsPool,
            $instructionsPool->logicWorkerInstructions->load_data
        );
        // загрузка состояния
        $dataPool = $workersPool->stateWorker->loadStateData($dataPool, $toolsPool);
        // загрузка статистики
        $dataPool = $workersPool->statisticsWorker->loadStatisticsData($dataPool, $toolsPool);

        return $dataPool;
    }
}
