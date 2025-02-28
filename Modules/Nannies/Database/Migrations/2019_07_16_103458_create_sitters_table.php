<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSittersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sitters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('house_number')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();           
            $table->string('date_of_birth')->nullable();
            $table->string('begin_date')->nullable();
            $table->decimal('hourly_rate', 4, 2)->nullable();
            $table->string('gender')->nullable();
            $table->string('job_description')->nullable();
            $table->string('years_of_experience')->nullable();
            $table->string('mother_tongue')->nullable();
            $table->text('languages')->nullable();
            $table->string('stages_experience')->nullable();
            $table->string('activities')->nullable();
            $table->string('qualifications')->nullable();
            $table->string('additional_services')->nullable();
            $table->text('general_text')->nullable();
            $table->string('profile_pic')->nullable();
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
        Schema::dropIfExists('sitters');
    }
}
