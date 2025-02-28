<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhotoSampleTextToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('contact_number')->nullable()->after('foot_commerce');
            $table->string('whatsapp')->nullable()->after('foot_commerce');
            $table->text('nanny_photo_example_bottom_text')->nullable()->after('job_description_tooltip');
            $table->text('nanny_photo_example_top_text')->nullable()->after('job_description_tooltip');
            $table->text('nanny_photo_example_heading')->nullable()->after('job_description_tooltip');
            $table->text('parent_photo_example_bottom_text')->nullable()->after('job_description_tooltip');
            $table->text('parent_photo_example_top_text')->nullable()->after('job_description_tooltip');
            $table->text('parent_photo_example_heading')->nullable()->after('job_description_tooltip');
            $table->text('mentor_photo_example_bottom_text')->nullable()->after('job_description_tooltip');
            $table->text('mentor_photo_example_top_text')->nullable()->after('job_description_tooltip');
            $table->text('mentor_photo_example_heading')->nullable()->after('job_description_tooltip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'contact_number',
                'whatsapp',
                'mentor_photo_example_bottom_text',
                'mentor_photo_example_top_text',
                'mentor_photo_example_heading',
                'parent_photo_example_bottom_text',
                'parent_photo_example_top_text',
                'parent_photo_example_heading',
                'nanny_photo_example_bottom_text',
                'nanny_photo_example_top_text',
                'nanny_photo_example_heading'
            ]);
        });
    }
}
