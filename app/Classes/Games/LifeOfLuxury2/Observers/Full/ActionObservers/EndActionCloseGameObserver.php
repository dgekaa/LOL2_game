<?php

namespace App\Classes\Games\LifeOfLuxury2\Observers\Full\ActionObservers;

use Avior\GameCore\Base\IEvent;
use Avior\GameCore\Base\IObserver;
use Avior\GameCore\Base\IDataPool;
use App\Classes\Bridge777Games\BridgeService;

/**
 * Наблюдатель за событием окончания выполнения действия spin
 */
class EndActionCloseGameObserver implements IObserver
{
    /**
     * Выполнение реакции на событие
     *
     * @param  IEvent $event
     *
     * @return IDataPool
     */
    public function update(IEvent $event): IDataPool
    {
        if ($event->name === 'endActionCloseGame') {
            $token = $event->dataPool->requestData->token;
            $userId = $event->dataPool->requestData->userId;
            $gameId = $event->dataPool->requestData->gameId;
            $collect = $event->dataPool->requestData->collect;

            BridgeService::sendCloseGame($token, $userId, $gameId, $collect);
        }

        return $event->dataPool;
    }
}
