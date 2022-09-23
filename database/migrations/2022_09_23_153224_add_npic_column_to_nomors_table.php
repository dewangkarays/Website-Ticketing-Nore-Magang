<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNpicColumnToNomorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nomors', function (Blueprint $table) {
            $table->unsignedInteger('npic')->nullable()->after('npay');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nomors', function (Blueprint $table) {
            $table->dropColumn('npic');
        });
    }
}
