<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'country_id' =>1,
                'city_id' => 1,
                'user_id' => 2,
                'profile_name' => 'profile_name',
                'profile_email' =>'profile_email@gmail.com',
                'profile_type' =>'social',
                'profile_status' =>'public',
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 1,
                'country_id' =>1,
                'city_id' => 1,
                'user_id' => 3,
                'profile_name' => 'profile_name',
                'profile_email' =>'profile_email@gmail.com',
                'profile_type' =>'social',
                'profile_status' =>'public',
                'created_at' => Carbon::now(),
            ],
        ];
        \DB::table('user_profiles')->insert($users);
    }
}
