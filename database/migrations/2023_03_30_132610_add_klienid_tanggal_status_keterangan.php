<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKlienidTanggalStatusKeterangan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historyklien', function (Blueprint $table) {
            $table->bigInteger('klien_id')->nullable()->after('id');
            $table->integer('status')->nullable()->after('klien_id');
            $table->text('keterangan')->nullable()->after('status');
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
        $table->dropColumn('klien_id');
        $table->dropColumn('status');
        $table->dropColumn('keterangan');
        $table->dropSoftDeletes();
    }
}
