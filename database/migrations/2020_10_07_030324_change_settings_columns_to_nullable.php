<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSettingsColumnsToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('logo')->nullable()->change();
            $table->text('alamat')->nullable()->change();
            $table->string('no_telp')->nullable()->change();
            $table->string('penerima')->nullable()->change();
            $table->string('ttd_penerima')->nullable()->change();
            $table->string('ttd_pospenerima')->nullable()->change();
            $table->string('penagih')->nullable()->change();
            $table->string('pospenagih')->nullable()->change();
            $table->text('catatan_tagihan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
}
