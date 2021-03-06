<?php

namespace App\Classes\Games\LifeOfLuxury2\RequestDataSets;

use Avior\GameCore\RequestDataSets\CloseGameRequestData as BaseCloseGameRequestData;

/**
 * Класс описывающий все данные, которые могут получаться из запросов
 */
class CloseGameRequestData extends BaseCloseGameRequestData
{
    /** @var string токен от 777games */
    public $token;

    /** @var string collect-значение для 777games */
    public $collect;

    /** @var int id платформы для 777games */
    public $platformId;
}
