<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cmsType = [
            [
                'id' => 1,
                'cms_side_bar_id' => 1,
                'content' => 'About Us Content',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'id' => 2,
                'cms_side_bar_id' => 2,
                'content' => 'Privacy Content',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'id' => 3,
                'cms_side_bar_id' => 3,
                'content' => 'Terms and condition content',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'id' => 4,
                'cms_side_bar_id' => 4,
                'content' => 'Signup Terms Content',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'id' => 5,
                'cms_side_bar_id' => 5,
                'content' => 'Marketing Content',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        \DB::table('cms_types')->insert($cmsType);
    }
}
