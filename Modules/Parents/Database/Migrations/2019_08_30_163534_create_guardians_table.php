<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuardiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('house_number')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('begin_date')->nullable();
            $table->string('job_description')->nullable();
            $table->decimal('hourly_rate', 4, 2)->nullable();
            $table->integer('num_of_children')->nullable();
            $table->string('gender_of_children')->nullable();
            $table->string('age_of_children')->nullable();
            $table->integer('eldest_child')->nullable();
            $table->integer('youngest_child')->nullable();
            $table->string('mother_tongue')->nullable();
            $table->text('languages')->nullable();
            $table->string('stages_experience')->nullable();
            $table->string('additional_services')->nullable();
            $table->string('activities')->nullable();
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
        Schema::dropIfExists('guardians');
    }
}
