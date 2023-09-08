<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeColumnNullableInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kliens', function (Blueprint $table) {
            $table->string('nama_calonklien')->nullable()->change();
            $table->string('nama_perusahaan')->nullable()->change();
            $table->text('jenis_perusahaan')->nullable()->change();
            $table->integer('potensi')->nullable()->change();
            $table->date('tanggal_kontakpertama')->nullable()->change();
            $table->integer('status')->nullable()->change();
            $table->string('telp')->nullable()->change();
            $table->string('alamat')->nullable()->change();
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
            
        });
    }
}
