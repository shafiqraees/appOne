<?php

namespace Database\Seeders;

use App\Models\Cms;
use App\Models\CmsSideBar;
use App\Models\CmsType;
use App\Models\Package;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesPermissionsTablesSeeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables();
        $this->call(RolesPermissionsTablesSeeder::class);
        //$this->call(UserTableSeeder::class);
        $this->call(CmsSideBarTableSeeder::class);
        $this->call(CmsTableSeeder::class);
        $this->call(PackageTableSeeder::class);
        //$this->call(UserProfileSeeder::class);
    }

    public function truncateTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        //User::truncate();
        CmsSideBar::truncate();
        CmsType::truncate();
        Package::truncate();
        //UserProfile::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
