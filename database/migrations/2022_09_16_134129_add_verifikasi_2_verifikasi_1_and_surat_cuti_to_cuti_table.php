<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerifikasi2Verifikasi1AndSuratCutiToCutiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cuti', function (Blueprint $table) {
            $table->integer('verifikasi_2')->default('1')->after('verifikator_2');
            $table->integer('verifikasi_1')->default('1')->after('verifikator_1');
            $table->string('surat_cuti')->nullable()->after('catatan_ver_1');
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
            $table->dropColumn('verifikasi_2');
            $table->dropColumn('verifikasi_1');
            $table->dropColumn('surat_cuti');
        });
    }
}
