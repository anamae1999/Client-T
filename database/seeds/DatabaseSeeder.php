<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(Modules\Admin\Entities\Admin::class, 1)->create();
        // $users = factory(Modules\Nannies\Entities\Sitter::class, 10)->create();
    	// $users = factory(Modules\Parents\Entities\Guardian::class, 10)->create();
        // $schedule = factory(App\Schedule::class, 20)->create();
        // $vetting = factory(App\Vetting::class, 5)->create();
        // $messages = factory(App\Message::class, 100)->create();
    }

}
