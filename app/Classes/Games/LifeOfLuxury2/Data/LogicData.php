<?php

namespace App\Classes\Games\LifeOfLuxury2\Data;

use Avior\GameCore\Data\LogicData as CoreLogicData;

/**
 * Класс содержит все данные, которые связаны с игровой логикой
 */
class LogicData extends CoreLogicData
{
    /** @var int max ставка */
    public $maxLineBet = 20;

    /** @var int max кол-во линий для хода */
    public $maxLinesInGame = 20;

    /** @var int общее кол-во ходов в featureGame */
    public $countOfMovesInFeatureGame = 12;

    /** @var int максимально кол-во ходов в featureGame которое доступно для пользователя со старта */
    public $startCountOfFreeSpinsInFeatureGame = 12;

    /** @var int ставка */
    public $lineBet = 20;

    /** @var int выбранное кол-во линий для хода */
    public $linesInGame = 20;
}
