<?php

namespace Modules\Mentors\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Admin\Entities\Content;

class MentorContentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contents = [
            // home mentors section
            [
                'section_name' => 'mentors', 
                'content_types' => 'mentors-title'
            ],
            [
                'section_name' => 'mentors', 
                'content_types' => 'mentors-content'
            ],
            [
                'section_name' => 'mentors', 
                'content_types' => 'mentors-btn-text'
            ],
            [
                'section_name' => 'mentors', 
                'content_types' => 'mentors-btn-link'
            ],
        ];

        Content::insert($contents);
    }
}
