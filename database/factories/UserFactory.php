<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Modules\Nannies\Entities\Sitter;
use Modules\Parents\Entities\Guardian;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'account_status' => $faker->randomElement(['activated', 'suspended', 'blocked']),
        'account_type' => $faker->randomElement(['free', 'premium']),
        'lat' => $faker->latitude(45,55),
        'lng' => $faker->longitude(4,10),
    ];
});

$factory->define(Modules\Admin\Entities\Admin::class, function ($faker) {
    return [        
        'user_id' => function () {
            return factory(App\User::class)->create([                
                'id' => 1, 
                'first_name' => 'Fname', 
                'last_name' => 'Lname', 
                'email' => 'admin@tinysteps.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'admin',
                'account_status' => 'admin',
                'account_type' => 'admin',
                'lat' => null,
                'lng' => null,
                'created_at'=>date('Y-m-d H:i:s'), 
                'updated_at'=>date('Y-m-d H:i:s')
            ])->id;
        },
        'admin_pic' => null
    ];
});

$factory->define(Modules\Nannies\Entities\Sitter::class, function ($faker) {
    return [        
        'user_id' => function () {
            return factory(App\User::class)->create([
                'role' => 'sitter'
            ])->id;
        },
        'hourly_rate' => $faker->numberBetween(1, 10),
        'gender' => $faker->randomElement(['male', 'female']),
        'job_description' => $faker->randomElement(['Permanent Nanny', 'Occasional Sitter', 'Afterschool Sitter','Night Sitter']),
        'years_of_experience' => $faker->numberBetween(1, 20),
        'mother_tongue' => $faker->randomElement(['English', 'Dutch']),
        'general_text' => $faker->sentence
    ];
});

$factory->define(Modules\Parents\Entities\Guardian::class, function ($faker) {
    return [        
        'user_id' => function () {
            return factory(App\User::class)->create([
                'role' => 'parent'
            ])->id;
        },
        'hourly_rate' => $faker->numberBetween(1, 10),
        'job_description' => $faker->randomElement(['Permanent Nanny', 'Occasional Sitter', 'Afterschool Sitter','Night Sitter']),
        'mother_tongue' => $faker->randomElement(['English', 'Dutch']),
        'general_text' => $faker->sentence
    ];
});

$factory->define(App\Vetting::class, function ($faker) {
    return [        
        'user_id' => $faker->unique(true)->numberBetween(1, 5),
        'application_status' => 'pending',
        'remarks' =>  $faker->word,
        'status' =>  'unverified'
    ];
});

$factory->define(App\Schedule::class, function ($faker) {
    return [        
        'user_id' => $faker->unique(true)->numberBetween(2, 21),
        'mon_dawn' => $faker->randomElement([0, 1]),
        'mon_morning' => $faker->randomElement([0, 1]),
        'mon_afternoon' => $faker->randomElement([0, 1]),
        'mon_evening' => $faker->randomElement([0, 1]),
        'tue_dawn' => $faker->randomElement([0, 1]),
        'tue_morning' => $faker->randomElement([0, 1]),
        'tue_afternoon' => $faker->randomElement([0, 1]),
        'tue_evening' => $faker->randomElement([0, 1]),
        'wed_dawn' => $faker->randomElement([0, 1]),
        'wed_morning' => $faker->randomElement([0, 1]),
        'wed_afternoon' => $faker->randomElement([0, 1]),
        'wed_evening' => $faker->randomElement([0, 1]),
        'thu_dawn' => $faker->randomElement([0, 1]),
        'thu_morning' => $faker->randomElement([0, 1]),
        'thu_afternoon' => $faker->randomElement([0, 1]),
        'thu_evening' => $faker->randomElement([0, 1]),
        'fri_dawn' => $faker->randomElement([0, 1]),
        'fri_morning' => $faker->randomElement([0, 1]),
        'fri_afternoon' => $faker->randomElement([0, 1]),
        'fri_evening' => $faker->randomElement([0, 1]),
        'sat_dawn' => $faker->randomElement([0, 1]),
        'sat_morning' => $faker->randomElement([0, 1]),
        'sat_afternoon' => $faker->randomElement([0, 1]),
        'sat_evening' => $faker->randomElement([0, 1]),
        'sun_dawn' => $faker->randomElement([0, 1]),
        'sun_morning' => $faker->randomElement([0, 1]),
        'sun_afternoon' => $faker->randomElement([0, 1]),
        'sun_evening' => $faker->randomElement([0, 1])
    ];
});

// $factory->define(App\Message::class, function (Faker $faker) {
//     do {
//         $from = rand(1, 20);
//         $to = rand(1, 20);
//     } while ($from === $to);

//     return [
//         'from' => $from,
//         'to' => $to,
//         'text' => $faker->sentence
//     ];
// });



