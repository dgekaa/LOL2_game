<?php

namespace App\Classes\Games\LifeOfLuxury2\Tools\LogicTools;

use Avior\GameCore\Tools\LogicTools\WinLinesTool as BaseWinLinesTool;

/**
 * помошник для работы с запросом с фронта
 */
class WinLinesTool extends BaseWinLinesTool
{
    /**
     * Получение выигрыша по линиям
     * При наличии в выишрышной линии алмаза выигрышь за линию удваивается
     *
     * @param int $lineBet
     * @param array $table
     * @param array $winningLines
     * @param array $winCombinations
     * @param array $lines
     * @param string $screen
     *
     * @return array [['lineNumber' => , 'winValue' => ], ...]
     */
    public function getPayoffsForLines(
        int $lineBet,
        array $table,
        array $winningLines,
        array $winCombinations,
        array $lines,
        int $multiplier = 1
    ): array
    {
        $payoffsForLines = [];
        foreach ($winningLines as $winningLine) {
            if (isset($winCombinations[$winningLine['symbol']][$winningLine['winCellCount']])) {
                // проверка наличия алмаза в выигрышной комбинации
                $diamondInWinCombination = $this->checkDiamondInWinCombination(
                    $table, $lines, $winningLine['lineNumber']
                );

                // умножение при наличии алмаза
                if ($diamondInWinCombination) {
                    $winValue = $winCombinations[$winningLine['symbol']][$winningLine['winCellCount']] * 2;
                } else {
                    $winValue = $winCombinations[$winningLine['symbol']][$winningLine['winCellCount']];
                }

                // умножение на ставку по линии
                $winValue *= $lineBet;

                // умножение на множитель
                $winValue *= $multiplier;

                $payoffsForLines[] = [
                    'lineNumber' => $winningLine['lineNumber'],
                    'winValue' => $winValue
                ];
            }
        }

        return $payoffsForLines;
    }

    /**
     * Проверка наличия алмаза в выигрышной комбинации
     *
     * @param  array $table      [description]
     * @param  array $lines      [description]
     * @param  int   $lineNumber [description]
     *
     * @return bool              [description]
     */
    protected function checkDiamondInWinCombination(
        array $table,
        array $lines,
        int $lineNumber
    ): bool
    {
        // подсчет кол-ва выигрышных символов в комбинации
        $countWinSymbols = 0;
        $winSymbol = $table[$lines[$lineNumber][0]];
        foreach ($lines[$lineNumber] as $key => $value) {
            if ($table[$lines[$lineNumber][$key]] === $winSymbol) {
                $countWinSymbols += 1;
            }
        }

        $check = false;
        foreach ($lines[$lineNumber] as $key => $symbol) {
            // если в линии есть алмаз
            if ($table[$symbol] === 0) {
                // если алмаз стоит сразу после выигршных символов, либо между ними
                if ($key <= $countWinSymbols) {
                    $check = true;
                    break;
                }
            }
        }

        return $check;
    }

    /**
     * Получение кол-ва символов в комбинации
     *
     * @param array $table сгенерированные значения ячеек стола
     * @param array $line номера клеток через которые проходит линия
     *
     * @return int кол-ва символов в комбинации
     */
    protected function getNumberOfWonCells(array $table, array $line): int
    {
        $winCellCount = 0;
        if ($table[$line[0]] === $table[$line[1]] || $table[$line[1]] === 0) {
            $winCellCount = 2;

            if ($table[$line[0]] === $table[$line[2]] || $table[$line[2]] === 0) {
                $winCellCount = 3;

                if ($table[$line[0]] === $table[$line[3]] || $table[$line[3]] === 0) {
                    $winCellCount = 4;

                    if ($table[$line[0]] === $table[$line[4]]) {
                        $winCellCount = 5;
                    }
                }
            }
        }

        return $winCellCount;
    }

    /**
     * Проверка есть ли на линии выигрышная комбинация
     *
     * @param array $table сгенерированные значения ячеек стола
     * @param array $line номера клеток через которые проходит линия
     * @param int $winCellCount кол-во выигрышных символов
     *
     * @return bool
     */
    protected function checkWhetherLineWon(
        array $table,
        array $line,
        int $winCellCount
    ): bool
    {
        $checkWinLines = false;
        if ($winCellCount > 2) {
            $checkWinLines = true;
        } elseif ($winCellCount === 2 && $table[$line[0]] === 1) {
            $checkWinLines = true;
        } elseif ($winCellCount === 2 && $table[$line[0]] === 9) {
            $checkWinLines = true;
        }

        return $checkWinLines;
    }
}
