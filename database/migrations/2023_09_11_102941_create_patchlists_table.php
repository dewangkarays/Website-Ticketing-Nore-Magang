<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatchlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patchlists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('klien_id');
            $table->unsignedBigInteger('proyek_id');
            $table->text('patchlist')->nullable();
            $table->integer('prioritas')->nullable();
            $table->integer('kesulitan')->nullable();
            $table->integer('status')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patchlists');
    }
}
