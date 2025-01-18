<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $testUser = User::where('email', 'test@test.com')->firstOrFail();


        $jobsId = Job::pluck('id')->toArray();

        $randomKeys = array_rand($jobsId, 3);

        foreach ($randomKeys as $key) {
            $testUser->bookmarks()->attach($jobsId[$key]);
        }
    }
}
