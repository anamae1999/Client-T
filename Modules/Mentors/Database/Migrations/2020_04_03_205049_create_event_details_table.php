<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('agenda_id');
            $table->text('dates')->nullable();
            $table->text('start_time')->nullable();
            $table->text('end_time')->nullable();
            $table->string('venue')->nullable();
            $table->string('language')->nullable();
            $table->decimal('fee', 4, 2)->nullable();
            $table->string('promo')->nullable();
            $table->timestamps();

            $table->foreign('agenda_id')
                ->references('id')
                ->on('agendas')
                ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_details');
    }
}
