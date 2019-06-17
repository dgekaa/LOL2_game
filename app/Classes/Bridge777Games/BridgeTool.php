<?php

namespace App\Classes\Bridge777Games;

/**
 * Класс содержит методы для выполнения простых операций над данными
 * с которыми работает Bridge777Games
 */
class BridgeTool
{
    /**
     * Получить значение direction
     *
     * @param  int    $totalPayoff общий выигрышь
     *
     * @return string
     */
    static public function getDirectionParametr(int $totalPayoff): string
    {
        if ($totalPayoff > 0) {
            return 'credit';
        } else {
            return 'debit';
        }
    }

    /**
     * Получить значение eventType
     *
     * @param  int    $totalPayoff общий выигрышь
     *
     * @return string
     */
    static public function getEventTypeParametr(int $totalPayoff): string
    {
        if ($totalPayoff > 0) {
            return 'Win';
        } else {
            return 'Lose';
        }
    }

    /**
     * Получение параметра result
     *
     * @param  array $table
     *
     * @return array
     */
    static public function getResultParametr(array $table): array
    {
        $newResult = [];
        foreach ($table as $key => $value) {
            switch ($value) {
                case 0:
                    $newResult[] = 'Diamond';
                    break;
                case 1:
                    $newResult[] = 'Plane';
                    break;
                case 2:
                    $newResult[] = 'Silver';
                    break;
                case 3:
                    $newResult[] = 'Dollar';
                    break;
                case 4:
                    $newResult[] = 'Car';
                    break;
                case 5:
                    $newResult[] = 'Ring';
                    break;
                case 6:
                    $newResult[] = 'Watch';
                    break;
                case 7:
                    $newResult[] = 'Gold';
                    break;
                case 8:
                    $newResult[] = 'Bronze';
                    break;
                case 9:
                    $newResult[] = 'Yacht';
                    break;
                case 10:
                    $newResult[] = 'Coin';
                    break;

                default:
                    $newResult[] = '';
                    break;
            }
        }

        return $newResult;
    }

    /**
     * Получение значения параметра featureGame
     *
     * @param  string $screen
     * @param  bool $isDromFeatureGame
     *
     * @return bool
     */
    static public function getFeatureGameParametr(string $screen, bool $isDropFeatureGame): bool
    {
        $featureGame = false;

        if ($screen === 'featureGame') {
            $featureGame = true;
        }

        if ($isDropFeatureGame) {
            $featureGame = true;
        }

        return $featureGame;
    }
}
