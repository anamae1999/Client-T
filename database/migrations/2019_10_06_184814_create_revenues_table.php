<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revenues', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->decimal('year', 4, 0);
            $table->integer('role');
            $table->decimal('jan')->default(0);
            $table->decimal('feb')->default(0);
            $table->decimal('mar')->default(0);
            $table->decimal('apr')->default(0);
            $table->decimal('may')->default(0);
            $table->decimal('jun')->default(0);
            $table->decimal('jul')->default(0);
            $table->decimal('aug')->default(0);
            $table->decimal('sep')->default(0);
            $table->decimal('oct')->default(0);
            $table->decimal('nov')->default(0);
            $table->decimal('dec')->default(0);            
            $table->decimal('revenue',9,2);
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
        Schema::dropIfExists('revenues');
    }
}
