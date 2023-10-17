<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeSomeColumnNullableInTpenjualanHsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tpenjualan_hs', function (Blueprint $table) {
            //
            $table->string('payment_mthd', 64)->nullable()->change();
            $table->string('noreff', 64)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tpenjualan_hs', function (Blueprint $table) {
            //
        });
    }
}
