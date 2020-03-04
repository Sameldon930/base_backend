<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;


class CreatePermissionMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z_permission_menu', function(Blueprint $table)
        {
            $table->integer('permission_id');
            $table->integer('menu_id');
            $table->index(['permission_id','menu_id'], 'permission_menu_permission_id_menu_id_index');
        });
        DB::statement("ALTER TABLE `z_permission_menu` comment'权限菜单关系表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('z_permission_menu');
    }
}
