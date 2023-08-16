<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiskonToTpenjualanHsTable extends Migration
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
            $table->decimal('diskon', $precision = 19, $scale = 6);
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
