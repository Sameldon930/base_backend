<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z_admins', function(Blueprint $table)
        {
            $table->increments('id')->comment('ID');
            $table->string('user_name')->unique('admins_username_unique')->comment('管理员名');
            $table->string('email')->unique('admins_email_unique')->comment('邮件');
            $table->string('mobile', 11)->nullable()->comment('手机号码');
            $table->smallInteger('sex')->default(1)->comment('性别');
            $table->string('password', 60)->comment('密码');
            $table->string('remember_token', 100)->nullable()->comment('TOKEN');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `z_admins` comment'管理员表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('z_admins');
    }
}
