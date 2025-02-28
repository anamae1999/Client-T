<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Content;

class AddContactNumberToContentsTableSeeder extends Seeder
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
            [
                'section_name' => 'form-and-image', 
                'content_types' => 'form-and-image-contact-num'
            ]
        ];

        Content::insert($contents);
    }
}
