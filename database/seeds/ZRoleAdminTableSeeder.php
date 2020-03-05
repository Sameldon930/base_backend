<?php

use Illuminate\Database\Seeder;

/**
 * 管理员角色关系表
 * Class AdminRoleUserTableSeeder
 */
class ZRoleAdminTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('z_role_admin')->delete();
        \DB::table('z_role_admin')->insert(array(
            0 =>
                array(
                    'user_id' => 1,
                    'role_id' => 1,
                ),
        ));
    }
}