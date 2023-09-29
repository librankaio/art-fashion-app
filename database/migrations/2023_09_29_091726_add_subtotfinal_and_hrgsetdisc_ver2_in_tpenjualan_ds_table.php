<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubtotfinalAndHrgsetdiscVer2InTpenjualanDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tpenjualan_ds', function (Blueprint $table) {
            //
            $table->decimal('subtotfinal', $precision = 19, $scale = 6)->nullable();
            $table->decimal('hrgsetdisc', $precision = 19, $scale = 6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tpenjualan_ds', function (Blueprint $table) {
            //
        });
    }
}
