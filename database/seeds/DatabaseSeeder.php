<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ZAdminsTableSeeder::class);
        $this->call(ZMenusTableSeeder::class);
        $this->call(ZRolesTableSeeder::class);
        $this->call(ZPermissionsTableSeeder::class);
        $this->call(ZRoleAdminTableSeeder::class);
        $this->call(ZRoleMenuTableSeeder::class);
        $this->call(ZPermissionMenuTableSeeder::class);
        $this->call(ZPermissionRoleTableSeeder::class);
    }
}
