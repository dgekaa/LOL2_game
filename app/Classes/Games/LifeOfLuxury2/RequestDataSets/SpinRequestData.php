<?php

namespace App\Classes\Games\LifeOfLuxury2\RequestDataSets;

use Avior\GameCore\RequestDataSets\SpinRequestData as BaseSpinRequestData;

/**
 * Класс описывающий все данные, которые могут получаться из запросов
 */
class SpinRequestData extends BaseSpinRequestData
{
    /** @var string токен от 777games */
    public $token;

    /** @var int id платформы для 777games */
    public $platformId;
}
