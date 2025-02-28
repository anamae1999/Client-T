<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('sitter_1mo', 6, 2)->default(0.00);
            $table->decimal('sitter_3mo', 6, 2)->default(0.00);
            $table->decimal('parent_1mo', 6, 2)->default(0.00);
            $table->decimal('parent_3mo', 6, 2)->default(0.00);
            $table->boolean('vetting')->default(0);
            $table->boolean('cookie')->default(1);
            $table->text('payment_notice')->nullable();
            $table->mediumText('headhtml')->nullable();
            $table->mediumText('foothtml')->nullable();
            $table->string('foot_heading')->nullable();
            $table->text('foot_content')->nullable();
            $table->string('foot_copyright')->nullable();
            $table->string('foot_email')->nullable();
            $table->string('foot_commerce')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->boolean('trial')->default(0);
            $table->string('trial_start')->nullable();
            $table->string('trial_end')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
