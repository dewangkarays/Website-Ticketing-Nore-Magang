<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihanCicilanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihan_cicilan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tagihan_id')->nullable();
            $table->integer('pembayaran_ke')->nullable();
            $table->bigInteger('jml_cicilan')->nullable();
            $table->bigInteger('rekap_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tagihan_cicilan');
    }
}
