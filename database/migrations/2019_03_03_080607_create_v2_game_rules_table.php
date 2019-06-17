<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateV2GameRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v2_game_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id');
            $table->string('name'); // lines, featureGame, jackpot, doubleGame
            $table->text('rules'); // json
            $table->timestamps();

            $table->index('game_id');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('v2_game_rules');
    }
}
