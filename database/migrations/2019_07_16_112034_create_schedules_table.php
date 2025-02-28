<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->unsigned(); 
            $table->boolean('mon_dawn')->default(0);           
            $table->boolean('mon_morning')->default(0);
            $table->boolean('mon_afternoon')->default(0);
            $table->boolean('mon_evening')->default(0);
            $table->boolean('tue_dawn')->default(0);            
            $table->boolean('tue_morning')->default(0);
            $table->boolean('tue_afternoon')->default(0);
            $table->boolean('tue_evening')->default(0);
            $table->boolean('wed_dawn')->default(0);            
            $table->boolean('wed_morning')->default(0);
            $table->boolean('wed_afternoon')->default(0);
            $table->boolean('wed_evening')->default(0);
            $table->boolean('thu_dawn')->default(0);           
            $table->boolean('thu_morning')->default(0);
            $table->boolean('thu_afternoon')->default(0);
            $table->boolean('thu_evening')->default(0);
            $table->boolean('fri_dawn')->default(0);            
            $table->boolean('fri_morning')->default(0);
            $table->boolean('fri_afternoon')->default(0);
            $table->boolean('fri_evening')->default(0);
            $table->boolean('sat_dawn')->default(0);            
            $table->boolean('sat_morning')->default(0);
            $table->boolean('sat_afternoon')->default(0);
            $table->boolean('sat_evening')->default(0);
            $table->boolean('sun_dawn')->default(0);             
            $table->boolean('sun_morning')->default(0);
            $table->boolean('sun_afternoon')->default(0);
            $table->boolean('sun_evening')->default(0);   
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('schedules');
    }
}
