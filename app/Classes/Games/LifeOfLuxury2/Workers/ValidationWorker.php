<?php

namespace App\Classes\Games\LifeOfLuxury2\Workers;

use Avior\GameCore\Workers\ValidationWorker as BaseValidationWorker;
use Avior\GameCore\Base\IToolsPool;
use Avior\GameCore\Exeptions\Worker\ValidationWorker\IncorrectRequestExeption;

class ValidationWorker extends BaseValidationWorker
{
    /**
     * Проверка данных запускающих игру
     *
     * @param array $requestArray
     * @param IToolsPool $toolsPool
     */
    public function validateStartGameRequest(array $requestArray, IToolsPool $toolsPool)
    {

    }

    /**
     * Проверка игровых данных для spin запроса
     *
     * @param array $requestArray
     * @param IToolsPool $toolsPool
     */
    public function validateSpinRequest(array $requestArray, IToolsPool $toolsPool)
    {
        try {

            if ($requestArray['linesInGame'] > 20) {
                throw new IncorrectRequestExeption('linesInGame > 20');
            }

            if ($requestArray['lineBet'] > 20) {
                throw new IncorrectRequestExeption('lineBet > 20');
            }

        } catch (IncorrectRequestExeption $e) {
            die(json_encode(["status" => "false", "message" => $e->getMessage()]));
        }

    }

    /**
     * Проверка игровых данных для free_spin запроса
     *
     * @param array $requestArray
     * @param IToolsPool $toolsPool
     */
    public function validateFreeSpinRequest(array $requestArray, IToolsPool $toolsPool)
    {

    }
}
