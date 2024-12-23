<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\AdminMember;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\AdminManagenent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'admin@gmail.com',
            'role_id' => 1,
            'password' => Hash::make('password'),
        ]);
        
        User::create([
            'first_name' => 'saller',
            'last_name' => 'user',
            'email' => 'saller@gmail.com',
            'role_id' => 2,
            'password' => Hash::make('password'),
        ]);
        
        User::create([
            'first_name' => 'customer',
            'last_name' => 'user',
            'email' => 'customer@gmail.com',
            'role_id' => 3,
            'password' => Hash::make('password'),
        ]);
    }
}
