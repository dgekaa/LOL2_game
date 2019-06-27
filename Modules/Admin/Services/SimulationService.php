<?php

namespace Modules\Admin\Services;

use Avior\GameCore\Base\IGameDirector;

class SimulationService
{
    public static function execute(
        array $requestArray,
        string $alias, IGameDirector
        $gameDirector
    ): object {
        $responseJson = $gameDirector
            ->build('demo')
            ->executeAction($requestArray);

        $data = json_decode($responseJson);

        return $data;
    }

    public static function addStatisticSymbolsInWinBonus(object $data): object
    {
        $statisticSymbolsInWinBonus = [0,0,0,0,0,0]; // [кол-во символов => кол-во выигрышных выпадений]
        foreach ($data->statisticsData->statisticOfWinBonusCombinations as $key => $syblols) {
            foreach ($syblols as $key2 => $value) {
                $statisticSymbolsInWinBonus[$key] += $value;
            }
        }
        $data->statisticSymbolsInWinBonus = $statisticSymbolsInWinBonus;

        return $data;
    }

    public static function fixMinDroppendJokersInFeatureGame(object $data): object
    {
        // приведение минимального кол-ва выпавших алмазов в featureGame к понятному числу
        if ($data->statisticsData->minDroppendDiamandsInFeatureGame === 9999) {
            $data->statisticsData->minDroppendDiamandsInFeatureGame = $data->statisticsData->maxDroppendDiamandsInFeatureGame;
        }

        return $data;
    }
}
