<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddingKeteranganColumnToLampiranGambarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lampiran_gambars', function (Blueprint $table) {
            $table->string('keterangan')->nullable()->after('gambar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lampiran_gambars', function (Blueprint $table) {
            $table->dropColumn(['keterangan']);
        });
    }
}
