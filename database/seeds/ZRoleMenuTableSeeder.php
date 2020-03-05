<?php

use Illuminate\Database\Seeder;

/**
 * 角色菜单关系表数据填充
 * Class AdminRoleMenuTableSeeder
 */
class ZRoleMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('z_role_menu')->delete();
        \DB::table('z_role_menu')->insert(array(
            0 =>
                array(
                    'role_id' => 1,
                    'menu_id' => 1,
                ),
            1 =>
                array(
                    'role_id' => 1,
                    'menu_id' => 2,
                ),
            2 =>
                array(
                    'role_id' => 1,
                    'menu_id' => 3,
                ),
            3 =>
                array(
                    'role_id' => 1,
                    'menu_id' => 4,
                ),
            4 =>
                array(
                    'role_id' => 1,
                    'menu_id' => 5,
                ),
            5 =>
                array(
                    'role_id' => 1,
                    'menu_id' => 6,
                ),
            6 =>
                array(
                    'role_id' => 1,
                    'menu_id' => 7,
                )
        ));
    }
}