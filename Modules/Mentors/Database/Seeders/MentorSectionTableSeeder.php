<?php

namespace Modules\Mentors\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Admin\Entities\Section;

class MentorSectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $sections = [
            // Home Section seeders
            [ 
                'page_id' => '1', 
                'section_names' => 'mentors'
            ],
        ];

        Section::insert($sections);
    }
}
