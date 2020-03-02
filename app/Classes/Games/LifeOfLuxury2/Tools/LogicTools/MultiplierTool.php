<?php

namespace App\Classes\Games\LifeOfLuxury2\Tools\LogicTools;

use Avior\GameCore\Base\ITool;

/**
 * помошник для работы с запросом с фронта
 */
class MultiplierTool implements ITool
{
    /**
     * Изменение множителя в зависимости от выпадения каких либо символов
     *
     * @param int $multiplier
     * @param array $table
     *
     * @return int
     */
    public function chengeMultiplierIfDroppedDiamand(
        int $multiplier,
        array $table
    ): int
    {
        $count = 0;
        foreach ($table as $value) {
            if ($value === 0) {
                $count += 1;
            }
        }
        $multiplier += $count;

        // множитель не может быть больше 29
        if ($multiplier > 29) {
            $multiplier = 29;
        }

        return $multiplier;
    }
}
