<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMemberCreatedOnKliensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kliens', function (Blueprint $table) {
            $table->boolean('member_created')->default(false)->after('source');
            
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
                $table->dropColumn('member_created');
        });
        
    }
}
