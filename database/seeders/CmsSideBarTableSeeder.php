<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CmsSideBarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cmsSideBar = [
            [
                'id' => 1,
                'name' => 'About Us',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'id' => 2,
                'name' => 'Privacy',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'id' => 3,
                'name' => 'Terms',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'id' => 4,
                'name' => 'Signup Terms',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'id' => 5,
                'name' => 'Marketing',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        \DB::table('cms_side_bars')->insert($cmsSideBar);
    }
}
