<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJenisAtToProyeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proyeks', function ($table) {
            $table->integer('jenis_proyek')->nullable()->after('website');
            $table->integer('jenis_layanan')->nullable()->after('jenis_proyek');
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
            $table->dropColumn('jenis_proyek');
            $table->dropColumn('jenis_layanan');
        });
    }
}
