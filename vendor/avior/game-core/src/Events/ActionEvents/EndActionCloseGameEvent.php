<?php

namespace Avior\GameCore\Events\ActionEvents;

use Avior\GameCore\Events\BaseEvent;

class EndActionCloseGameEvent extends BaseEvent
{
    /** @var string название события */
    public $name = 'endActionCloseGame';
}
