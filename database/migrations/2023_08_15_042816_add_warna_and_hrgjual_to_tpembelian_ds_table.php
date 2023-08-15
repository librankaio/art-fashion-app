<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWarnaAndHrgjualToTpembelianDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tpembelian_ds', function (Blueprint $table) {
            $table->string('warna', 64);
            $table->decimal('hrgjual', $precision = 19, $scale = 6);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tpembelian_ds', function (Blueprint $table) {
            //
        });
    }
}
