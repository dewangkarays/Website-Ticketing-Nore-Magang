<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalColumnToPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('receipt_no')->after('tgl_bayar');
            $table->string('penerima')->nullable();
            $table->string('ttd_penerima')->nullable();
            $table->string('ttd_pospenerima')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('receipt_no');
            $table->dropColumn('penerima');
            $table->dropColumn('ttd_penerima');
            $table->dropColumn('ttd_pospenerima');
        });
    }
}
