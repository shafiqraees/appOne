<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class UserTableSeeder extends Seeder
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
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' =>bcrypt('12345678'),
                'user_type' =>'admin',
                'profile_photo_path' =>'profiles/5fd1bcdde6728.jpeg',
                'gender' =>'Male',
                'date_of_birth' =>'2020-06-06',
                'org_password' => '12345678',
                'device_token' => 'sdadadsdadasdasdadad',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'country_id' =>1,
                'city_id' => 1,
                'name' => 'Front User',
                'email' => 'user1@gmail.com',
                'password' =>bcrypt('12345678'),
                'user_type' =>'user',
                'profile_photo_path' =>'profiles/5fd1bcdde6728.jpeg',
                'gender' =>'Male',
                'date_of_birth' =>'2020-06-06',
                'org_password' => '12345678',
                'device_token' => 'sdadadsdadasdasdadad',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 3,
                'country_id' =>1,
                'city_id' => 1,
                'name' => 'Front User',
                'email' => 'user2@gmail.com',
                'password' =>bcrypt('12345678'),
                'user_type' =>'user',
                'profile_photo_path' =>'profiles/5fd1bcdde6728.jpeg',
                'gender' =>'Male',
                'date_of_birth' =>'2020-06-06',
                'org_password' => '12345678',
                'device_token' => 'sdadadsdadasdasdadad',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        \DB::table('users')->insert($users);
    }
}
