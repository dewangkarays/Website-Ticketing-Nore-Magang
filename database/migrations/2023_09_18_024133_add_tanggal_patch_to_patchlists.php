<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTanggalPatchToPatchlists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patchlists', function (Blueprint $table) {
            $table->timestamp('tanggal_patch')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patchlists', function (Blueprint $table) {
            $table->dropColumn('tanggal_patch');
        });
    }
}
