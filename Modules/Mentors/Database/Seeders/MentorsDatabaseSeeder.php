<?php

namespace Modules\Mentors\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class MentorsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $this->call([           
            MentorSectionTableSeeder::class,
            MentorContentTableSeeder::class,
        ]);
    }
}
