<?php
/**
 * Created by PhpStorm.
 * User: zzs
 */
return [
    //user
    'user_table'                            =>  'z_users',
    'user_table_cannot_manage_ids'          =>  '1',

    //role
    'role'                                  => 'App\Models\Role',
    'role_table'                            => 'z_roles',
    'role_user_table'                       => 'z_role_admin',
    'role_foreign_key'                      => 'role_id',
    'user_foreign_key'                      => 'user_id',
    'role_admin'                            => 'admin',
    'role_auth_page'                        =>  'errors.role',
    'role_table_cannot_manage_ids'          =>  '1',

    //permission
    'permission'                            => 'App\Models\Permission',
    'permission_table'                      => 'z_permissions',
    'permission_role_table'                 => 'z_permission_role',
    'permission_name'                       => 'name',
    'permission_display_name'               => 'display_name',
    'permission_controller'                 => 'controllers',
    'permission_menu_table'                 => 'z_permission_menu',
    'permission_foreign_key'                => 'permission_id',
    'permission_table_cannot_manage_ids'    => '1,2,3,4,5,6,7,8,9',

    //menu
    'menu'                                  => 'App\Models\Menu',
    'menu_table'                            => 'z_menus',
    'menu_role_table'                       => 'z_role_menu',
    'menu_foreign_key'                      => 'menu_id',
    'menu_table_id_key'                     => 'id',
    'menu_table_parent_id_key'              => 'parent_id',
    'menu_table_cannot_manage_ids'          =>  '1,2,3,4,5,6,7',

    'db_log'                                =>  env('DB_LOG', false),
    //cache
    'admin_permissions_for_role_id'           =>'ap_id',
    //cannot del
    'cannot_del_admin_ids'          =>  '1',

];