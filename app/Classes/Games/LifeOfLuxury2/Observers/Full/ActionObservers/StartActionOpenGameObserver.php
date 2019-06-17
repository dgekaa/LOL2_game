<?php

namespace App\Classes\Games\LifeOfLuxury2\Observers\Full\ActionObservers;

use Avior\GameCore\Base\IEvent;
use Avior\GameCore\Base\IObserver;
use Avior\GameCore\Base\IDataPool;
use Webpatser\Uuid\Uuid;
use App\Classes\Bridge777Games\BridgeService;

/**
 * Наблюдатель за событием начала открытия игры (действия open_game)
 */
class StartActionOpenGameObserver implements IObserver
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
        if ($event->name === 'startActionOpenGame') {
            // если запущен demo режим и делается открытие игры, то баланс приводится к исходному
            if ($event->dataPool->requestData->mode === 'demo') {
                $event->toolsPool->dataTools->balanceDataTool->resetUserBalanceForDemoGame(
                    $event->dataPool->requestData->userId
                );
            }
        }

        return $event->dataPool;
    }
}
