<?php

namespace App\Classes\Games\LifeOfLuxury2\Data;

use Avior\GameCore\Data\SessionData as BaseSessionData;

/**
 * Класс содержит дополнительные данные от сессии для работы с 777games
 */
class SessionData extends BaseSessionData
{
    /** @var bool uuid события для 777games */
    public $eventId;
}
