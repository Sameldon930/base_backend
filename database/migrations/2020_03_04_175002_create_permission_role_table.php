<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;


class CreatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z_permission_role', function(Blueprint $table)
        {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned()->index('permission_role_role_id_foreign');
            $table->primary(['permission_id','role_id']);
        });
        DB::statement("ALTER TABLE `z_permission_role` comment'权限角色关系表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('z_permission_role');
    }
}
