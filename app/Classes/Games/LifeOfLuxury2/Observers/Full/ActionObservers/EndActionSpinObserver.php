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
class EndActionSpinObserver implements IObserver
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
        if ($event->name === 'endActionSpin') {
            // обновление eventId
            $event->dataPool->sessionData->eventId = Uuid::generate()->string;

            // отправка данных о снятии денег на 777games в основной игре
            $response = BridgeService::sendStartSpinMoveFunds(
                $event->dataPool->sessionData->eventId,
                $event->dataPool->requestData->token,
                $event->dataPool->requestData->userId,
                $event->dataPool->requestData->gameId,
                $event->dataPool->requestData->linesInGame,
                $event->dataPool->requestData->linesInGame * $event->dataPool->requestData->lineBet
            );

            // отрпвка данных с результатими хода в основной игре
            $response = BridgeService::sendEndSpinMoveFunds(
                $event->dataPool->sessionData->eventId,
                $event->dataPool->requestData->token,
                $event->dataPool->requestData->userId,
                $event->dataPool->requestData->gameId,
                $event->dataPool->requestData->linesInGame,
                $event->dataPool->balanceData->totalPayoff,
                $event->dataPool->logicData->table,
                $event->dataPool->stateData->screen,
                $event->dataPool->stateData->isDropFeatureGame
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
