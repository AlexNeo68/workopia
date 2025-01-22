<?php

namespace Database\Seeders;

use App\Models\Studio;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studios = include(database_path('seeders/data/studios.php'));

        $userIds = User::all()->pluck('id')->toArray();
        $testUserId = User::where('email', 'test@test.com')->first()->id;

        foreach ($studios as $index => $arStudio) {



            if ($index < 2) {
                $arStudio['user_id'] = $testUserId;
            } else {
                $arStudio['user_id'] = $userIds[array_rand($userIds)];
            }

            $arStudio['sort'] = $index + 1;

            $logo = $arStudio['logo'];

            unset($arStudio['logo']);

            $studio = new Studio($arStudio);


            $studio->save();

            if ($logo) {
                $studio->addMedia(storage_path('app/public/' . $logo))->preservingOriginal()->toMediaCollection('logo');
            }
        }

        // DB::table('job_listings')->insert($jobListings);
        echo 'Studio imported successfully!';
    }
}
