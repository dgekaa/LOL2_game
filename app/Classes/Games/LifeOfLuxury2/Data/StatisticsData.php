<?php

namespace App\Classes\Games\LifeOfLuxury2\Data;

use Avior\GameCore\Data\StatisticsData as BaseStatisticsData;

/**
 * Класс содержит дополнительные данные от сессии для работы с 777games
 */
class StatisticsData extends BaseStatisticsData
{
    /** @var int Кол-во алмазов выпавшее за текущую featureGame */
    public $droppendDiamandsInCurrentFeatureGame = 0;

    /** @var int min кол-во алмазов выпавшее в featureGame */
    public $minDroppendDiamandsInFeatureGame = 9999;

    /** @var int max кол-во алмазов выпавшее в featureGame */
    public $maxDroppendDiamandsInFeatureGame = 0;
}
