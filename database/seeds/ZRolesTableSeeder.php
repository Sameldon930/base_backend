<?php

use Illuminate\Database\Seeder;

/**
 * 角色表数据填充
 * Class AdminRolesTableSeeder
 */
class ZRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('z_roles')->delete();
        \DB::table('z_roles')->insert(array(
            0 =>
                array(
                    'id'                => 1,
                    'name'              => 'admin',
                    'display_name'      => '超级管理员',
                    'description'       => '最高级的权限',
                    'created_at'        => date('Y-m-d H:i:s', time()),
                    'updated_at'        => date('Y-m-d H:i:s', time()),
                ),
        ));
    }
}