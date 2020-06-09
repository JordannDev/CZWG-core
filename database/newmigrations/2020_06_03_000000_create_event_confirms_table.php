<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsConfirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_confirms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id');
            $table->text('event_name');
            $table->dateTime('event_date');
            $table->integer('user_cid');
            $table->text('user_name');
            $table->string('start_timestamp');
            $table->string('end_timestamp');
            $table->text('position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_confirms');
    }
}
