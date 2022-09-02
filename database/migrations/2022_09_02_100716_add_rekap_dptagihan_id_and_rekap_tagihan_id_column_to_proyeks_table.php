<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRekapDptagihanIdAndRekapTagihanIdColumnToProyeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proyeks', function (Blueprint $table) {
            $table->integer('rekap_dptagihan_id')->nullable();
            $table->integer('rekap_tagihan_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proyeks', function (Blueprint $table) {
            $table->dropColumn('rekap_dptagihan_id');
            $table->dropColumn('rekap_tagihan_id');
        });
    }
}
