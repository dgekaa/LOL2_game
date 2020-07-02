<?php

namespace App\Classes\Games\LifeOfLuxury2\Tools\LogicTools;

use Avior\GameCore\Tools\LogicTools\BonusCalculatorTool as CoreBonusCalculatorTool;

class BonusCalculatorTool extends CoreBonusCalculatorTool
{
    /**
     * Получение результатов выигрыша на бонусных символах для основной игры
     *
     * @param array $table
     * @param array $bonusRules
     *
     * @return array [['symbol' => , 'count' => , 'winning' => ], ...]
     */
    public function getBonusWinningsForMainGame(
        array $table,
        array $bonusRules,
        int $linesInGame,
        int $lineBet
    ): array
    {
        $bonusWinnings = [];

        // получение кол-ва монет
        $coinCounter = 0;
        foreach ($table as $value) {
            if ($value === 10) {
                $coinCounter += 1;
            }
        }

        // проверка наличия на поле алмазов
        $diamandCounter = 0;
        foreach ($table as $value) {
            if ($value === 0) {
                $diamandCounter += 1;
            }
        }

        // прибаление к монетам алмазов
        $coinCounter += $diamandCounter;

        // получение выигрыша
        $winning = $bonusRules[10][$coinCounter] * $linesInGame * $lineBet;

        if ($winning > 0) {
            $bonusWinnings[] = ['symbol' => 10, 'count' => $coinCounter, 'winning' => $winning];
        }

        return $bonusWinnings;
    }

    /**
     * Получение результатов выигрыша на бонусных символах для featureGame
     *
     * @param array $table
     * @param array $bonusRules
     * @param int $linesInGame
     * @param int $lineBet
     *
     * @return array [['symbol' => , 'count' => , 'winning' => ], ...]
     */
    public function getBonusWinningsForFeatureGame(
        array $table,
        array $bonusRules,
        int $linesInGame,
        int $lineBet,
        int $multiplier
    ): array
    {
        $bonusWinnings = [];

        // получение кол-ва монет
        $coinCounter = 0;
        foreach ($table as $value) {
            if ($value === 10) {
                $coinCounter += 1;
            }
        }

        // проверка наличия на поле алмазов
        $diamandCounter = 0;
        foreach ($table as $value) {
            if ($value === 0) {
                $diamandCounter += 1;
            }
        }

        // прибаление к монетам алмазов
        $coinCounter += $diamandCounter;

        // получение выигрыша
        $winning = $bonusRules[10][$coinCounter] * $linesInGame * $lineBet * $multiplier;

        if ($winning > 0) {
            $bonusWinnings[] = ['symbol' => 10, 'count' => $coinCounter, 'winning' => $winning];
        }

        return $bonusWinnings;
    }
}
