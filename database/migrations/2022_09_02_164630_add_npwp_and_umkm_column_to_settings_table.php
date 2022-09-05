<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNpwpAndUmkmColumnToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('npwp')->nullable()->after('logo');
            $table->string('umkm')->nullable()->after('npwp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proyeks', function (Blueprint $table) {
            $table->dropColumn('npwp');
            $table->dropColumn('umkm');
        });
    }
}
