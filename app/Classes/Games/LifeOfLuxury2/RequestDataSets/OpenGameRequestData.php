<?php

namespace App\Classes\Games\LifeOfLuxury2\RequestDataSets;

use Avior\GameCore\RequestDataSets\OpenGameRequestData as BaseOpenGameRequestData;

/**
 * Класс описывающий все данные, которые могут получаться из запросов
 */
class OpenGameRequestData extends BaseOpenGameRequestData
{
    /** @var string токен от 777games */
    public $token;
}
