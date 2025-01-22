<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        DB::table('job_listings')->truncate();
        DB::table('job_user_bookmarked')->truncate();
        DB::table('aplicants')->truncate();
        DB::table('studios')->truncate();

        $this->call([
            TestUserSeeder::class,
            RandomUserSeeder::class,
            JobSeeder::class,
            StudioSeeder::class,
        ]);
    }
}
