<?php

namespace App\Classes\Games\LifeOfLuxury2\Observers\Full\ActionObservers;

use Avior\GameCore\Base\IEvent;
use Avior\GameCore\Base\IObserver;
use Avior\GameCore\Base\IDataPool;
use Webpatser\Uuid\Uuid;
use App\Classes\Bridge777Games\BridgeService;
use App\Classes\Bridge777Games\BridgeBalanceRepository;

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

            // отрпвка данных с результатими хода
            $response = BridgeService::sendEndSpinMoveFunds(
                $event->dataPool->sessionData->eventId,
                $event->dataPool->requestData->token,
                $event->dataPool->requestData->userId,
                $event->dataPool->requestData->gameId,
                $event->dataPool->requestData->linesInGame,
                $event->dataPool->balanceData->totalPayoff,
                $event->dataPool->logicData->table,
                $event->dataPool->requestData->platformId,
                $event->dataPool->stateData->moveNumberInFeatureGame,
                $event->dataPool->stateData->isEndFeatureGame
            );

            // запись баланса в БД
            $dollarBalance = (float) json_decode($response)->balance;
            $centBalance = $dollarBalance * 100;
            BridgeBalanceRepository::updateUserBalance(
                $event->dataPool->requestData->userId,
                $event->dataPool->sessionData->mode,
                $centBalance
            );
        }

        return $event->dataPool;
    }
}
