<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpenerimaanHsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tpenerimaan_hs', function (Blueprint $table) {
            $table->id();
            $table->string('no', 64);
            $table->string('no_sj', 64);
            $table->string('counter', 64);
            $table->date('tgl');
            $table->string('note', 256);
            $table->string('jenis', 64);
            $table->decimal('grdtotal', $precision = 19, $scale = 6);
            $table->string('user', 64)->nullable();
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
        Schema::dropIfExists('tpenerimaan_hs');
    }
}
