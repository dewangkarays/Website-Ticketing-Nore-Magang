<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRekapTagihanIdAndRekapDpIdColumnToLampiranGambars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lampiran_gambars', function (Blueprint $table) {
            $table->bigInteger('rekap_tagihan_id')->nullable()->after('tagihan_id');
            $table->bigInteger('rekap_dptagihan_id')->nullable()->after('rekap_tagihan_id');
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
            $table->dropColumn('rekap_tagihan_id');
            $table->dropColumn('rekap_dptagihan_id');
        });
    }
}
