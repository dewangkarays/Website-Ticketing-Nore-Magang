<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCutiIzinSakitColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('cuti')->nullable()->default(0)->after('jabatan');
            $table->integer('izin')->nullable()->default(0)->after('cuti');
            $table->integer('sakit')->nullable()->default(0)->after('izin');
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
            $table->dropColumn('cuti');
            $table->dropColumn('izin');
            $table->dropColumn('sakit');
        });
    }
}
