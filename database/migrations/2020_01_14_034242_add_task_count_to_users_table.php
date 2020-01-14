<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaskCountToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('task_count')->nullable();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->tinyInteger('task_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['task_count']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['task_count']);
        });
    }
}
