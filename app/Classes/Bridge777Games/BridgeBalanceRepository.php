<?php

namespace App\Classes\Bridge777Games;

use App\Models\V2Balance;

class BridgeBalanceRepository
{
    // запись баланса в БД
    static public function updateUserBalance(
        int $userId,
        string $mode,
        float $value
    ): bool
    {
        // поиск баланса пользователя
        $v2Balance = V2Balance::where('mode', $mode)
            ->where('user_id', $userId)
            ->get()->first();

        // делается обновление
        if ($v2Balance) {
            $v2Balance->value = $value;
            $v2Balance->save();
        } else {
            // при его отсутсвии он создается
            $v2Balance = new V2Balance;
            $v2Balance->user_id = $userId;
            $v2Balance->mode = $mode;
            $v2Balance->value = $value;
            $v2Balance->save();
        }

        return true;
    }
}
