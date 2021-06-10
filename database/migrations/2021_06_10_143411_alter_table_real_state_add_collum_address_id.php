<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRealStateAddCollumAddressId extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('real_state', function (Blueprint $table) {

            $table->unsignedBigInteger('address_id')->nullable();

            $table->foreign('address_id')->references('id')->on('adresses');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('real_state', function (Blueprint $table) {

            $table->dropForeign('real_state_id_foreign');
            $table->dropColumn('address_id');

        });
    }
}
