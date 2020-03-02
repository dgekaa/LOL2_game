<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateV2SessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v2_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('session_uuid');
            $table->integer('user_id');
            $table->integer('game_id');
            $table->string('mode');
            $table->enum('status', ['work', 'done']);
            $table->timestamps();

            $table->unique('session_uuid');
            $table->index('session_uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('v2_sessions');
    }
}
