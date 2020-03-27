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

            // изменение экрана
            $event->dataPool->stateData->screen = 'featureGame';

            // изменение множителя
            $event->dataPool->logicData->multiplier = $event->dataPool->logicData->startMultiplierInFeatureGame;

            if ($event->dataPool->stateData->isWinOnMain) {
                // изменение текущего номера хода в featureGame
                $event->dataPool->stateData->moveNumberInFeatureGame = 0;
            }

            if ($event->dataPool->stateData->isWinOnFeatureGame) {
                // изменение текущего номера хода в featureGame
                $event->dataPool->stateData->moveNumberInFeatureGame -= 12;
            }


            // Обнуление кол-ва возможных бесплатных спинов
            $event->dataPool->logicData->countOfMovesInFeatureGame = $event->dataPool->logicData->startCountOfFreeSpinsInFeatureGame;

            // запись данных которые есть при выпадении фриспинов для хранения до окончания фриспинов
            $longData = new \stdClass;
            $longData->stateData = new \stdClass;
            $longData->stateData = $event->dataPool->stateData;
            $longData->balanceData = new \stdClass;
            $longData->balanceData = $event->dataPool->balanceData;
            $longData->logicData = new \stdClass;
            $longData->logicData = $event->dataPool->logicData;
            $event->dataPool->longData->data = $longData;
        }

        return $event->dataPool;
    }
}
