<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMobileNumberToSitters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sitters', function (Blueprint $table) {
            $table->text('contact_number')->nullable()->after('profile_pic');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sitters', function (Blueprint $table) {
            $table->dropColumn('contact_number');
        });
    }
}
