<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Developer
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'developer@atlasacademy.com',
            ],
            [
                'name' => 'Developer',
                'password' => Hash::make('Developer@123'),
                'role' => 'developer',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Director
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'director@atlasacademy.com',
            ],
            [
                'name' => 'Director',
                'password' => Hash::make('Director@123'),
                'role' => 'director',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'admin@atlasacademy.com',
            ],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin@123'),
                'role' => 'admin',
            ]
        );
    }
}