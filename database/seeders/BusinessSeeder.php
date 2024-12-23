<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\AdminMember;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\AdminManagenent;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = ['hotel', 'salon', 'clinic'];

        foreach ($roles as $role) {
            BusinessCategory::create([
                'name' => $role
            ]);
        }

        Business::create([
            'owner_id' => 2,
            'name' => $role,
            'business_category_id' => 1,
            'address' => 'suart',
            'longitude' => 72.2345,
            'latitude' => 102.2345,
        ]);

    }
}
