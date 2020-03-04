<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;


class CreateRoleMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z_role_menu', function(Blueprint $table)
        {
            $table->integer('role_id');
            $table->integer('menu_id');
            $table->index(['role_id','menu_id'], 'role_menu_role_id_menu_id_index');
        });
        DB::statement("ALTER TABLE `z_role_menu` comment'角色菜单关系表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('z_role_menu');
    }
}
