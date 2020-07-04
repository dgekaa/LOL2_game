<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixGameRuleLinesForLol2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\V2GameRule::where('game_id', 6)
            ->where('name', 'lines')
            ->update(['rules' => '[[1,4,7,10,13],[0,3,6,9,12],[2,5,8,11,14],[0,4,8,10,12],[2,4,6,10,14],[1,3,7,11,13],[1,5,7,9,13],[0,3,7,11,14],[2,5,7,9,12],[0,4,6,10,12],[2,4,8,10,14],[1,3,6,9,13],[1,5,8,11,13],[0,4,7,10,12],[2,4,7,10,14],[1,4,6,10,13],[1,4,8,10,13],[0,5,6,11,12],[2,3,8,9,14],[2,3,7,9,14]]']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\V2GameRule::where('game_id', 6)
            ->where('name', 'lines')
            ->update(['rules' => '[[1,4,7,10,13],[0,3,6,9,12],[2,5,8,11,14],[0,4,8,10,12],[2,4,6,10,14],[1,3,7,11,13],[1,5,7,9,13],[0,3,7,11,14],[2,5,7,9,12],[0,4,6,10,12],[2,4,8,10,14],[1,3,6,9,13],[1,5,8,11,13],[0,4,7,10,12],[2,4,7,10,14],[1,4,6,10,13],[1,4,8,10,14],[0,5,6,11,12],[2,3,8,9,14],[2,3,7,9,14]]']);
    }
}
