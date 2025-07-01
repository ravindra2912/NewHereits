<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // SiteSetting::create([
        //     'yearly_subscription_price' => 199,
        //     'per_credit_price' => 1.3,
        // ]);

        $countries = database_path('sql/countries.sql');
        if (!File::exists($countries)) {
            echo "SQL file not found.";
            return;
        }
        DB::unprepared(File::get($countries));

        $states = database_path('sql/states.sql');

        if (!File::exists($states)) {
            echo "SQL file not found.";
            return;
        }
        DB::unprepared(File::get($states));
        
        
        $cities = database_path('sql/cities.sql');

        if (!File::exists($cities)) {
            echo "SQL file not found.";
            return;
        }
        DB::unprepared(File::get($cities));
    }
}
