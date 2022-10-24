<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "first_name" => "admin",
            "last_name" => "cyber",
            "email" => "admin@cyberolympus.com",
            "password" => bcrypt("cyberadmin"),
        ]);
    }
}
