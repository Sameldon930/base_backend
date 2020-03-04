<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z_roles', function(Blueprint $table)
        {
            $table->increments('id')->comment('ID');
            $table->string('name')->unique('roles_name_unique')->comment('角色名');
            $table->string('display_name')->nullable()->comment('显示名');
            $table->string('description')->nullable()->comment('描述');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `z_roles` comment'角色表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('z_roles');
    }
}
