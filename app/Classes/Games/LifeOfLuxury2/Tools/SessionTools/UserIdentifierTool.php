<?php

namespace App\Classes\Games\LifeOfLuxury2\Tools\SessionTools;

use Avior\GameCore\Base\ITool;
use App\Models\V2User;
use App\Models\V2Balance;

class UserIdentifierTool implements ITool
{
    public function checkUserOrCreate(int $id, string $token, string $mode): bool
    {
        $user = V2User::find($id);

        if ($user === null) {
            $user = new V2User;
            $user->id = $id;
            $user->session_token = $token;
            $user->save();
        }

        $balance = V2Balance::where('user_id', $id)->where('mode', $mode)->first();

        if ($balance === null) {
            $mode === 'demo' ? $value = 10000 : $value = 0;

            $balance = new V2Balance;
            $balance->user_id = $id;
            $balance->value = $value;
            $balance->mode = $mode;
            $balance->save();
        }

        return true;
    }
}
