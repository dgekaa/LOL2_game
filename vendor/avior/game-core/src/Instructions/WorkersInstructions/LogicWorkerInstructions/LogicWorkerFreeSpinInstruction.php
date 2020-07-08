<?php

namespace Avior\GameCore\Instructions\WorkersInstructions\LogicWorkerInstructions;

use Avior\GameCore\Base\IInstruction;
use Avior\GameCore\Base\IDataPool;
use Avior\GameCore\Base\IToolsPool;

/**
 * Класс содержащий набор методов, которые последовательно выполняются в воркером
 */
class LogicWorkerFreeSpinInstruction implements IInstruction
{
    /**
     * получение рандомного занчения стола
     *
     * @param  IDataPool  $dataPool  [description]
     * @param  IToolsPool $toolsPool [description]
     *
     * @return IDataPool             [description]
     */
    public function getCurrentPercentages(
        IDataPool $dataPool,
        IToolsPool $toolsPool
    ): IDataPool {
        if ($dataPool->systemData->tablePreset === []) {
            // получение процентов выпадения символов
            $currentPercentages = $toolsPool->logicTools->tableTool
            ->getCurrentPercentages(
                $dataPool->logicData->percentagesRules,
                $dataPool->stateData->screen,
                $dataPool->logicData->lineBet * $dataPool->logicData->linesInGame
            );

            do {
                $dataPool->logicData->table = $toolsPool->logicTools->tableTool->getRandomTable(
                    $currentPercentages
                );

                // исключение возможности выпадения больше $max_count алмазов в FreeSpin
                $check = $this->excludeMaxDiamandCountOnTable($dataPool->logicData->table, $dataPool->logicData->multiplier, 27);

                if($check) {
                    //проверка на $max_count Addition FreeSpin'a
                    $check = $this->excludeMaxAdditionFreeSpins($dataPool->logicData->table, $dataPool->logicData->countOfMovesInFeatureGame, 2);
                }
            } while (!$check);
        } else {
            $dataPool->logicData->table = $dataPool->systemData->tablePreset;
        }

        //$dataPool->logicData->table = [2,10,3,5,10,6,7,8,0,4,2,3,4,5,6]; // drop featureGame
        //$dataPool->logicData->table = [6,5,7,5,9,3,5,9,7,9,4,3,10,9,4]; // 15 * mul
        //$dataPool->logicData->table = [2,1,3,5,0,6,7,8,9,4,2,3,4,5,6];

        return $dataPool;
    }

    /**
     * Исключение возможности выпадения больше $max_count алмазов в FreeSpin
     *
     * @param array $table
     * @param $multiplier
     * @param int $max_count
     *
     * @return bool
     */
    protected function excludeMaxDiamandCountOnTable(array $table, int $multiplier, int $max_count)
    {
        $check = true;

        $bonusSymbolCount = 0;
        foreach ($table as $item) {
            if ($item === 0) {
                $bonusSymbolCount += 1;
            }
        }

        // -2 т.к. начинаем с множителя 2
        if ($bonusSymbolCount > 0) {
            if (($multiplier - 2 + $bonusSymbolCount) > $max_count) {
                $check = false;
            }
        }

        return $check;
    }

    /**
     * Проверка на $max_count Addition FreeSpin'a
     *
     * @param array $table
     * @param int $count_of_moves_in_feature_game
     * @param int $max_count
     *
     * @return bool
     */
    protected function excludeMaxAdditionFreeSpins(array $table, int $count_of_moves_in_feature_game, int $max_count)
    {
        $check = true;

        $bonusSymbolCount = 0;
        foreach ($table as $item) {
            if ($item === 0) {
                $bonusSymbolCount += 1;
            }
        }

        $coinSymbolCount = 0;
        foreach ($table as $item) {
            if ($item === 10) {
                $coinSymbolCount += 1;
            }
        }

        if(($bonusSymbolCount + $coinSymbolCount) >= 3) {
            if ((($count_of_moves_in_feature_game - 12) / 12) >= $max_count) {
                $check = false;
            }
        }

        return $check;
    }

    /**
     * получение выигрышных линий
     *
     * @param  IDataPool  $dataPool  [description]
     * @param  IToolsPool $toolsPool [description]
     *
     * @return IDataPool             [description]
     */
    public function getWinningLines(
        IDataPool $dataPool,
        IToolsPool $toolsPool
    ): IDataPool {
        $dataPool->logicData->winningLines = $toolsPool->logicTools->winLinesTool->getWinningLines(
            $dataPool->logicData->table,
            $dataPool->logicData->linesRules,
            $dataPool->logicData->linesInGame
        );

        return $dataPool;
    }

    /**
     * получение выигрыша по линиям
     *
     * @param  IDataPool  $dataPool  [description]
     * @param  IToolsPool $toolsPool [description]
     *
     * @return IDataPool             [description]
     */
    public function getPayoffsForLines(
        IDataPool $dataPool,
        IToolsPool $toolsPool
    ): IDataPool {
        $dataPool->logicData->payoffsForLines = $toolsPool->logicTools->winLinesTool->getPayoffsForLines(
            $dataPool->requestData->lineBet,
            $dataPool->logicData->table,
            $dataPool->logicData->winningLines,
            $dataPool->logicData->combinationsRules,
            $dataPool->logicData->linesRules,
            $dataPool->logicData->multiplier
        );

        return $dataPool;
    }

    /**
     * получение выигрышных ячеек
     *
     * @param  IDataPool  $dataPool  [description]
     * @param  IToolsPool $toolsPool [description]
     *
     * @return IDataPool             [description]
     */
    public function getWinningCells(
        IDataPool $dataPool,
        IToolsPool $toolsPool
    ): IDataPool {
        $dataPool->logicData->winningCells = $toolsPool->logicTools->winLinesTool->getWinningCells(
            $dataPool->logicData->table,
            $dataPool->logicData->winningLines,
            $dataPool->logicData->linesRules
        );

        return $dataPool;
    }

    // получения выигрыша по бонусным символам
    public function getBonusWinningsForFeatureGame(
        IDataPool $dataPool,
        IToolsPool $toolsPool
    ): IDataPool {
        $dataPool->logicData->payoffsForBonus = $toolsPool->logicTools->bonusCalculatorTool->getBonusWinningsForFeatureGame(
            $dataPool->logicData->table,
            $dataPool->logicData->bonusRules,
            $dataPool->logicData->linesInGame,
            $dataPool->logicData->lineBet,
            $dataPool->logicData->multiplier
        );

        return $dataPool;
    }
}
