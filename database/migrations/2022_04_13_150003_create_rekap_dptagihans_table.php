<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapDptagihansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_dptagihans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice');
            $table->bigInteger('user_id');
            $table->string('nama');
            $table->bigInteger('jml_terbayar')->nullable()->default(0);
            $table->bigInteger('total');
            $table->string('nama_tertagih');
            $table->string('alamat');
            $table->string('jatuh_tempo');
            $table->Integer('status')->default(1);
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('rekap_dptagihans');
    }
}
