<?php

namespace App\Classes\Games\LifeOfLuxury2;

use Illuminate\Http\Request;
use Avior\GameCore\Base\IGame;
use Avior\GameCore\GameDirector as BaseGameDirector;

/**
 * Класс подбирает команду(командир, рабочие, данные) для выполнения запроса
 * учитывая режим в катором запущеная игра
 */
class GameDirector extends BaseGameDirector
{
    protected function updateConfig(string $mode): bool
    {
        // сбор данных
        $this->dataPool->addData('sessionData', new \App\Classes\Games\LifeOfLuxury2\Data\SessionData);
        $this->dataPool->addData('logicData', new \App\Classes\Games\LifeOfLuxury2\Data\LogicData);
        $this->dataPool->addData('requestData', new \App\Classes\Games\LifeOfLuxury2\Data\RequestData);
        $this->dataPool->addData('userStatisticsData', new \App\Classes\Games\LifeOfLuxury2\Data\StatisticsData);
        $this->dataPool->addData('gameStatisticsData', new \App\Classes\Games\LifeOfLuxury2\Data\StatisticsData);

        // сбор набора данных, который будет обрабатываться при соответсвующих запросах
        $this->requestDataSetPool->addRequestData('open_game', new \App\Classes\Games\LifeOfLuxury2\RequestDataSets\OpenGameRequestData);
        $this->requestDataSetPool->addRequestData('close_game', new \App\Classes\Games\LifeOfLuxury2\RequestDataSets\CloseGameRequestData);
        $this->requestDataSetPool->addRequestData('spin', new \App\Classes\Games\LifeOfLuxury2\RequestDataSets\SpinRequestData);
        $this->requestDataSetPool->addRequestData('free_spin', new \App\Classes\Games\LifeOfLuxury2\RequestDataSets\FreeSpinRequestData);

        // сбор рабочих
        $this->workersPool->addWorker('responseWorker', new \App\Classes\Games\LifeOfLuxury2\Workers\ResponseWorker);

        // сбор инструменов
        $this->toolsPool->addTool('logicTools', 'tableTool', new \App\Classes\Games\LifeOfLuxury2\Tools\LogicTools\TableTool);
        $this->toolsPool->addTool('logicTools', 'winLinesTool', new \App\Classes\Games\LifeOfLuxury2\Tools\LogicTools\WinLinesTool);
        $this->toolsPool->addTool('logicTools', 'bonusCalculatorTool', new \App\Classes\Games\LifeOfLuxury2\Tools\LogicTools\BonusCalculatorTool);
        $this->toolsPool->addTool('logicTools', 'multiplierTool', new \App\Classes\Games\LifeOfLuxury2\Tools\LogicTools\MultiplierTool);
        $this->toolsPool->addTool('stateTools', 'stateCalculatorTool', new \App\Classes\Games\LifeOfLuxury2\Tools\StateTools\StateCalculatorTool);

        // подпись обсерверов на события
        $this->actionsPool->open_game->attach(new \App\Classes\Games\LifeOfLuxury2\Observers\Full\ActionObservers\StartActionOpenGameObserver);
        $this->workersPool->stateWorker->attach(new \App\Classes\Games\LifeOfLuxury2\Observers\Full\GameProcessObservers\StartFeatureGameObserver);
        $this->workersPool->stateWorker->attach(new \App\Classes\Games\LifeOfLuxury2\Observers\Full\GameProcessObservers\EndFeatureGameObserver);

        if ($mode === "full") {
            // подпись обсерверов на события
            $this->actionsPool->spin->attach(new \App\Classes\Games\LifeOfLuxury2\Observers\Full\ActionObservers\EndActionSpinObserver);
            $this->actionsPool->free_spin->attach(new \App\Classes\Games\LifeOfLuxury2\Observers\Full\ActionObservers\EndActionFreeSpinObserver);
        }

        if ($mode === "demo") {
            $this->actionsPool->free_spin->attach(new \App\Classes\Games\LifeOfLuxury2\Observers\Demo\ActionObservers\EndActionFreeSpinObserver);
        }

        return true;
    }
}
