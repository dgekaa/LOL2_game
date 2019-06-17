<?php

namespace App\Classes\Games\LifeOfLuxury2\Observers\Full\GameProcessObservers;

use Avior\GameCore\Base\IEvent;
use Avior\GameCore\Base\IDataPool;
use Avior\GameCore\Observers\Observer as BaseObserver;

class StartFeatureGameObserver extends BaseObserver
{
    public function update(IEvent $event): IDataPool
    {
        if ($event->name === 'startFeatureGame') {
            if ($event->dataPool->stateData->isWinOnMain === true) { // если выпала featureGame в основной игре
                // изменение экрана
                $event->dataPool->stateData->screen = 'featureGame';

                // изменение множителя
                $event->dataPool->logicData->multiplier = $event->dataPool->logicData->startMultiplierInFeatureGame;

                // изменение текущего номера хода в featureGame
                $event->dataPool->stateData->moveNumberInFeatureGame = 0;

                // Обнуление кол-ва возможных бесплатных спинов
                $event->dataPool->logicData->countOfMovesInFeatureGame = $event->dataPool->logicData->startCountOfFreeSpinsInFeatureGame;
            }
        }

        return $event->dataPool;
    }
}
