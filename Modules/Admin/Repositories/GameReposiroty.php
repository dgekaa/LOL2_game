<?php

namespace Modules\Admin\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Admin\Repositories\BaseRepository;
use App\Models\V2Game;

class GameReposiroty extends BaseRepository
{
    /**
     * Gettining game collection without "Core game"
     *
     * @return Collection
     */
    public static function getWorkGames(): Collection
    {
        // getting game collection
        $games = V2Game::where('id', '!=', 1)->get(['name', 'alias']);

        return $games;
    }
}
