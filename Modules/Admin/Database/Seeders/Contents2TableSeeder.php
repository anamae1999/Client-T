<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Content;

class Contents2TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $contents = [
            // Additional content for Services section
            [
                'section_name' => 'services', 
                'content_types' => 'service-modal1'
            ],
            [
                'section_name' => 'services', 
                'content_types' => 'service-modal2'
            ],
            [
                'section_name' => 'services', 
                'content_types' => 'service-modal3'
            ],

            // new content for screening
            [
                'section_name' => 'screening', 
                'content_types' => 'screening-title'
            ],
            [
                'section_name' => 'screening', 
                'content_types' => 'screening-content'
            ],

            // new content for sitter type
            [
                'section_name' => 'sitter-types', 
                'content_types' => 'sitter-types-title'
            ],
            [
                'section_name' => 'sitter-types', 
                'content_types' => 'sitter-types-content1'
            ],
            [
                'section_name' => 'sitter-types', 
                'content_types' => 'sitter-types-content2'
            ],
            [
                'section_name' => 'sitter-types', 
                'content_types' => 'sitter-types-content3'
            ],
            [
                'section_name' => 'sitter-types', 
                'content_types' => 'sitter-types-content4'
            ]
        ];

        Content::insert($contents);
    }
}
