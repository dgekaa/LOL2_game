<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteLastEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('last_events');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('last_events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('eventId')->unsigned()->default(0);
            $table->integer('transactionId')->unsigned()->default(0);
        });
    }
}
