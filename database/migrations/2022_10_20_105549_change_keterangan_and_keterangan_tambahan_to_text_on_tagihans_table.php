<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeKeteranganAndKeteranganTambahanToTextOnTagihansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tagihans', function (Blueprint $table) {
            $table->text('keterangan')->nullable()->change();
            $table->text('keterangan_tambahan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tagihans', function (Blueprint $table) {
            $table->string('keterangan')->nullable()->change();
            $table->string('keterangan_tambahan')->nullable()->change();
        });
    }
}
