<?php

namespace App\Classes\Games\LifeOfLuxury2\Tools\LogicTools;

use Avior\GameCore\Tools\LogicTools\TableTool as BaseTableTool;

/**
 * помошник для работы с запросом с фронта
 */
class TableTool extends BaseTableTool
{
    /**
     * Генерация значения ячейки исходя из выпавшего процента
     *
     * @param array $currentPercentage [description]
     * @param array $cellRow [description]
     *
     * @return int                       [description]
     */
    protected function generateCellValue(array $currentPercentageRangs, array $cellRow): int
    {
        $rand = rand(1, 99);

        // получение значения соответсвующего выпавшему проценту
        $cellValue = 123123;
        foreach ($currentPercentageRangs as $key => $valuePercRang) {
            if ($rand >= $valuePercRang[0] && $rand < $valuePercRang[1]) {
                $cellValue = $key;
            }
        }

        // исключение совпадения символов в барабане
        if ($this->checkDropSameSymbolsInDrum($cellValue, $cellRow)) {
            return $this->generateCellValue($currentPercentageRangs, $cellRow);
        }

        // исключение выпадения алмаз и монета на одном барабане
        if ($this->checkDropDiamandAndCoinInDrum($cellValue, $cellRow)) {
            return $this->generateCellValue($currentPercentageRangs, $cellRow);
        }

        return $cellValue;
    }

    /**
     * Проверка выпадения в барабане двух одинаковых символов
     *
     * @param int $cellValue [description]
     * @param array $cellRow [description]
     *
     * @return bool             [description]
     */
    private function checkDropSameSymbolsInDrum(int $cellValue, array $cellRow): bool
    {
        if (in_array($cellValue, $cellRow)) {
            return true;
        }

        return false;
    }

    /**
     * Проверка выпадения в барабане алмаза и монеты
     *
     * @param int $cellValue [description]
     * @param array $cellRow [description]
     *
     * @return bool             [description]
     */
    private function checkDropDiamandAndCoinInDrum(int $cellValue, array $cellRow): bool
    {
        if ($cellValue === 0) {
            if (in_array(10, $cellRow)) {
                return true;
            }
        }
        if ($cellValue === 10) {
            if (in_array(0, $cellRow)) {
                return true;
            }
        }

        return false;
    }
}
