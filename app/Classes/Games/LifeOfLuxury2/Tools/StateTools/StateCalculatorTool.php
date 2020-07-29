<?php

namespace App\Classes\Games\LifeOfLuxury2\Tools\StateTools;

use Avior\GameCore\Tools\StateTools\StateCalculatorTool as BaseStateCalculatorTool;

/**
 * Класс содержащий методы для определения состояния после окончания хода
 */
class StateCalculatorTool extends BaseStateCalculatorTool
{
    /**
     * Вычисление выпала ли featureGame
     *
     * @param string $screen
     * @param array $table
     * @param array $featureGameRules [symbol, requiredAmount]
     *
     * @return bool
     */
    public function calculateIsDropFeatureGame(
        string $screen,
        array $table,
        array $featureGameRules
    ): bool
    {
        $isDropFeatureGame = false;

        if ($screen === 'mainGame' || $screen === 'featureGame') {
            // подсчет кол-ва выпавших символов
            $count = 0;
            foreach ($table as $key => $value) {
                if ($value === $featureGameRules[0] || $value === 0) {
                    $count += 1;
                }
            }

            // проверка достаточно ли символов для выпадения featureGame
            if ($count >= $featureGameRules[1]) {
                $isDropFeatureGame = true;
            }
        }

        return $isDropFeatureGame;
    }

    // /**
    //  * Изменение текущего номера хода с учетом выпадения новой featureGame
    //  *
    //  * @param int $moveNumberInFeatureGame
    //  * @param bool $isDropFeatureGame
    //  *
    //  * @return int
    //  */
    // public function updateCountOfMovesInFeatureGame(
    //     int $countOfMovesInFeatureGame,
    //     bool $isDropFeatureGame
    // ): int
    // {
    //     // уменьшение кол-ва сделанных ходов
    //     if ($isDropFeatureGame) {
    //         $countOfMovesInFeatureGame += 12;
    //     }
    //
    //     return $countOfMovesInFeatureGame;
    // }

    /**
     * Обнуление кол-ва возможных бесплатных спинов если они закончились
     *
     * @param int $moveNumberInFeatureGame
     * @param int $countOfMovesInFeatureGame
     *
     * @return int
     */
    public function nullableCountOfMovesIfEndFeatureGame(
        int $moveNumberInFeatureGame,
        int $countOfMovesInFeatureGame
    ): int
    {
        if ($moveNumberInFeatureGame === $countOfMovesInFeatureGame) {
            $countOfMovesInFeatureGame = 12;
        }

        return $countOfMovesInFeatureGame;
    }
}
