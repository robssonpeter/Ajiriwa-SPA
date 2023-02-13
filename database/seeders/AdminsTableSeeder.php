<?php

use App\Models\Admin;


Admin::create([
    'name' => $faker->name,
    'email' => 'admin@gmail.com',
    'password' => bcrypt('password'),
]);