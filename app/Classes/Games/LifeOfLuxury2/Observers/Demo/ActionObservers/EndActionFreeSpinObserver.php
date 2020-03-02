<?php

namespace App\Classes\Games\LifeOfLuxury2\Observers\Demo\ActionObservers;

use Avior\GameCore\Base\IEvent;
use Avior\GameCore\Base\IObserver;
use Avior\GameCore\Base\IDataPool;
use Webpatser\Uuid\Uuid;
use App\Classes\Bridge777Games\BridgeService;

/**
 * Наблюдатель за событием окончания выполнения действия spin
 */
class EndActionFreeSpinObserver implements IObserver
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
        if ($event->name === 'endActionFreeSpin') {
            // изменение множителя в случает выпадения алмаза
            if ($event->dataPool->stateData->isEndFeatureGame === false || $event->dataPool->stateData->isDropFeatureGame) {
                $event->dataPool->logicData->multiplier = $event->toolsPool->logicTools->multiplierTool
                ->chengeMultiplierIfDroppedDiamand(
                    $event->dataPool->logicData->multiplier,
                    $event->dataPool->logicData->table
                );
            }

            // проверка выпадения featureGame в featureGame
            if ($event->dataPool->stateData->isDropFeatureGame === true) {
                $event->dataPool->stateData->isDropFeatureGameInFeatureGame = true;
                $event->dataPool->stateData->isEndFeatureGame = false;
                $event->dataPool->logicData->countOfMovesInFeatureGame += 12;
            }
        }

        return $event->dataPool;
    }
}
