<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('invoice');
            $table->Integer('langganan')->default('0');
            $table->Integer('ads')->default('0');
            $table->Integer('lainnya')->default('0');
            $table->Integer('jml_tagih')->default('0');
            $table->Integer('jml_bayar')->default('0');
            $table->tinyInteger('status')->default('0');
            $table->string('keterangan');
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
        Schema::dropIfExists('tagihans');
    }
}
