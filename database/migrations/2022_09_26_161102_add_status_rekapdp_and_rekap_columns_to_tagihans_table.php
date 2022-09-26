<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusRekapdpAndRekapColumnsToTagihansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tagihans', function (Blueprint $table) {
            $table->integer('status_rekapdp')->nullable()->default(0)->after('uang_muka');
            $table->integer('status_rekap')->nullable()->default(0)->after('jml_tagih');
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
            $table->dropColumn('status_rekapdp');
            $table->dropColumn('status_rekap');
        });
    }
}
