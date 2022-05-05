<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAndChangeSomeColumnsToPengeluarans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengeluarans', function (Blueprint $table) {
            $table->string('nama_pj')->after('user_id');
            $table->string('pengeluaran')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengeluarans', function (Blueprint $table) {
            //
        });
    }
}
