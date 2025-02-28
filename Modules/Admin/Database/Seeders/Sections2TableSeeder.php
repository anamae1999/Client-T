<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Section;

class Sections2TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();

        $sections = [
            // Screening Section seeders
            [ 
                'page_id' => '1', 
                'section_names' => 'screening'
            ],
            // Sitter types
            [ 
                'page_id' => '1', 
                'section_names' => 'sitter-types'
            ],
        ];

        Section::insert($sections);
    }
}
