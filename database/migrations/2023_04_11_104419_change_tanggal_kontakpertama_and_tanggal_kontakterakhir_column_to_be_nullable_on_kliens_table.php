<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTanggalKontakpertamaAndTanggalKontakterakhirColumnToBeNullableOnKliensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kliens', function (Blueprint $table) {
            $table->date('tanggal_kontakpertama')->nullable()->change();
            $table->date('tanggal_kontakterakhir')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kliens', function (Blueprint $table) {
            //
        });
    }
}
