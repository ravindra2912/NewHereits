<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\AdminMember;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\AdminManagenent;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = ['admin', 'saller', 'customer'];

        foreach($roles as $role)
        UserRole::create([
            'role_name' => $role
        ]);
        
        
    }
}
