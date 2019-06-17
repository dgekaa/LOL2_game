<?php

namespace App\Classes\Games\LifeOfLuxury2\Observers\Full\GameProcessObservers;

use Avior\GameCore\Base\IEvent;
use Avior\GameCore\Base\IDataPool;
use Avior\GameCore\Observers\GameProcessObservers\EndFeatureGameObserver as BaseEndFeatureGameObserver;

class EndFeatureGameObserver extends BaseEndFeatureGameObserver
{
    public function update(IEvent $event): IDataPool
    {
        if ($event->name === 'endFeatureGame') {
            $event->dataPool = parent::update($event);

            // если на последнем ходу не выпадает еще одна featureGame, то
            if ($event->dataPool->stateData->isDropFeatureGame === false) {
                // обнуление кол-ва сделанных бесплатных спинов если они закончились
                $event->dataPool->stateData->moveNumberInFeatureGame = 0;

                // обнуление экрана если бесплатные спины закончились
                $event->dataPool->stateData->screen = 'mainGame';

                // обнуление множителя в случае окончания featureGame
                $event->dataPool->logicData->multiplier = 1;

                // обнуление кол-ва возможных бесплатных спинов если они закончились
                $event->dataPool->logicData->countOfMovesInFeatureGame = 12;
            }
        }

        return $event->dataPool;
    }
}
