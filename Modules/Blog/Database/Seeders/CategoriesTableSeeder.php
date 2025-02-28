<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Blog\Entities\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = [
            [ 
                'category' => 'nannies', 
                'created_at' => date('d/m/y H:i:s'),
                'updated_at' => date('d/m/y H:i:s'),
            ],
            [ 
                'category' => 'parents', 
                'created_at' => date('d/m/y H:i:s'),
                'updated_at' => date('d/m/y H:i:s'),
            ],
        ];

        Category::insert($categories);
    }
}
