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
        $dataPool = $workersPool->balanceWorker->executeInstruction(
            $dataPool,
            $toolsPool,
            $instructionsPool->balanceWorkerInstructions->loadData
        );
        // загрузка логики
        $dataPool = $workersPool->logicWorker->executeInstruction(
            $dataPool,
            $toolsPool,
            $instructionsPool->logicWorkerInstructions->loadData
        );
        // загрузка состояния
        $dataPool = $workersPool->stateWorker->executeInstruction(
            $dataPool,
            $toolsPool,
            $instructionsPool->stateWorkerInstructions->loadData
        );
        // загрузка статистики
        $dataPool = $workersPool->statisticsWorker->executeInstruction(
            $dataPool,
            $toolsPool,
            $instructionsPool->userStatisticsWorkerInstructions->loadData
        );

        return $dataPool;
    }
}
