<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSourceAndKeteranganLainOnKliensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kliens', function (Blueprint $table) {
            $table->integer('source')->nullable()->after('alamat');
            $table->text('keterangan_lain')->nullable()->after('source');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kliens', function (Blueprint $table) {
            $table->dropColumn('source');
            $table->dropColumn('keterangan_lain');
            $table->dropSoftDeletes();
        });
    }
}
