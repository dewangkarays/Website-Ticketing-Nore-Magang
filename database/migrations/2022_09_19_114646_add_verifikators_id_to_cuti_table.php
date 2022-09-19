<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerifikatorsIdToCutiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cuti', function (Blueprint $table) {
            $table->bigInteger('verifikator_2_id')->nullable()->after('catatan_ver_2');
            $table->bigInteger('verifikator_1_id')->nullable()->after('catatan_ver_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cuti', function (Blueprint $table) {
            $table->dropColumn('verifikator_2_id');
            $table->dropColumn('verifikator_1_id');
        });
    }
}
