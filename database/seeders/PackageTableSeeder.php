<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PackageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = [
            [
                'id' => 1,
                'name' => 'Package 1',
                'credits' => '25',
                'price' =>  '50',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'id' => 2,
                'name' => 'Package 2',
                'credits' => '50',
                'price' => '75',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'id' => 3,
                'name' => 'Package 3',
                'credits' => '75',
                'price' =>  '100',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        \DB::table('packages')->insert($packages);

    }
}
