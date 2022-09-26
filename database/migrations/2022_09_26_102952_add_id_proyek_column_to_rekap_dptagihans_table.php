<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdProyekColumnToRekapDptagihansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekap_dptagihans', function (Blueprint $table) {
            $table->bigInteger('id_proyek')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekap_dptagihans', function (Blueprint $table) {
            $table->dropColumn('id_proyek');
        });
    }
}
