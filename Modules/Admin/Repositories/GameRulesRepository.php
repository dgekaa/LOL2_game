<?php

namespace Modules\Admin\Repositories;

use Illuminate\Support\Collection;
use Modules\Admin\Repositories\BaseRepository;
use App\Models\V2GameRule;
use App\Models\V2Game;
use DB;

class GameRulesRepository extends BaseRepository
{
    /**
     * Получение правил по процентам от игры по ее алиасу
     *
     * @return string
     */
    public static function getPercentagesRulesByAlias(string $alias): string
    {
        $percentagesRules = V2GameRule::where('game_id', 6)->where('name', 'percentages')->first()->rules;
        // $percentagesRules = DB::table('v2_games')
        //     ->join('v2_game_rules', 'v2_games.id', '=', 'v2_game_rules.game_id')
        //     ->select('v2_game_rules.rules', 'v2_game_rules.name')
        //     ->where('v2_games.alias', $alias)
        //     ->where('v2_game_rules.name', 'percentages')
        //     ->get()->first()->rules;

        return $percentagesRules;
    }

    /**
     * Получение правил по процентам от игры по ее алиасу
     *
     * @param  string $alias            [description]
     * @param  array  $percentagesRules [description]
     *
     * @return object                    [description]
     */
    public static function savePercentagesRulesByAlias(string $alias, array $percentagesRules): object
    {
        $rule = V2GameRule::where('game_id', 6)->where('name', 'percentages')->first();
        $rule->rules = json_encode($percentagesRules);
        $rule->save();

        return $rule;
    }

}
