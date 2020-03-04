<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z_logs', function(Blueprint $table)
        {
            $table->integer('id', true)->comment('ID');
            $table->integer('admin_id')->comment('用户ID');
            $table->string('user_name')->nullable()->comment('用户名');
            $table->string('log_url', 128)->nullable()->comment('URL');
            $table->string('log_ip', 20)->nullable()->comment('ip');
            $table->string('log_info', 100)->nullable()->comment('描述');
            $table->datetime('log_time')->nullable()->comment('日志日期');
        });
        DB::statement("ALTER TABLE `z_logs` comment'日志表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('z_logs');
    }
}
