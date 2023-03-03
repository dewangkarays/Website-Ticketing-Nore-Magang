<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKliensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kliens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_calonklien');
            $table->string('nama_perusahaan');
            $table->text('jenis_perusahaan');
            $table->integer('potensi');
            $table->date('tanggal_kontakpertama');
            $table->date('tanggal_kontakterakhir');
            $table->integer('status');
            $table->string('telp');
            $table->string('alamat');
            $table->bigInteger('marketing_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kliens');
    }
}
