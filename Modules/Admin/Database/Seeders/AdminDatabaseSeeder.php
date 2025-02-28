<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use DB;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([           
            PagesTableSeeder::class,
            SectionsTableSeeder::class,
            ContentsTableSeeder::class,
        ]);

        DB::table('settings')->insert([
            'id' => 1,
            'created_at'=>date('Y-m-d H:i:s'), 
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
    }
}
