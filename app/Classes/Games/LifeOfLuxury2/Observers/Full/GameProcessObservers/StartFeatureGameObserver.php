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


            // изменение экрана
            $event->dataPool->stateData->screen = 'featureGame';

            if ($event->dataPool->stateData->isWinOnMain) {
                // изменение текущего номера хода в featureGame
                $event->dataPool->stateData->moveNumberInFeatureGame = 0;
            }

            // Обнуление кол-ва возможных бесплатных спинов
            $event->dataPool->logicData->countOfMovesInFeatureGame = $event->dataPool->logicData->startCountOfFreeSpinsInFeatureGame;

            // запись данных которые есть при выпадении фриспинов для хранения до окончания фриспинов
            $longData = new \stdClass;
            $longData->stateData = new \stdClass;
            $longData->stateData = $event->dataPool->stateData;
            $longData->balanceData = new \stdClass;
            $longData->balanceData = $event->dataPool->longData->data->balanceData;
            $longData->balanceData->totalWinningsInFeatureGame = $event->dataPool->balanceData->totalWinningsInFeatureGame;
            $longData->logicData = new \stdClass;
            $longData->logicData = $event->dataPool->longData->data->logicData;
            $event->dataPool->longData->data = $longData;

        }

        if ($event->name === 'endFeatureGame' && $event->dataPool->stateData->isEndFeatureGame) {
            // запись данных которые есть при выпадении фриспинов для хранения до окончания фриспинов
            $longData = new \stdClass;
            $longData->stateData = new \stdClass;
            $longData->stateData = $event->dataPool->stateData;
            $longData->balanceData = new \stdClass;
            $longData->balanceData = $event->dataPool->longData->data->balanceData;
            $longData->balanceData->totalWinningsInFeatureGame = $event->dataPool->balanceData->totalWinningsInFeatureGame;
            $longData->logicData = new \stdClass;
            $longData->logicData = $event->dataPool->longData->data->logicData;
            $event->dataPool->longData->data = $longData;
        }

        return $event->dataPool;
    }
}
