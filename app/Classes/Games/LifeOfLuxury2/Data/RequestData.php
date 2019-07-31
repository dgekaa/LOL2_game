<?php

namespace App\Classes\Games\LifeOfLuxury2\Data;

use Avior\GameCore\Data\RequestData as BaseRequestData;

/**
 * Класс описывает все данные которые могут быть получены из запроса
 */
class RequestData extends BaseRequestData
{
    /** @var string токен от 777games */
    public $token = "";

    /** @var string collect-значение для 777games */
    public $collect = "";
}
