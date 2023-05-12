<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetMarketingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('target_marketings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('marketing_id')->nullable();
            $table->date('periode')->nullable();
            $table->bigInteger('target_leads')->nullable();
            $table->bigInteger('target_deal')->nullable();
            $table->bigInteger('target_nominal')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('target_marketings');
    }
}
