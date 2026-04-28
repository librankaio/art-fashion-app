<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTstockopnameDsTable extends Migration
{
    public function up()
    {
        Schema::create('tstockopname_d', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idh');
            $table->string('no_opname', 64);
            $table->integer('no');
            $table->string('kode_barang', 64);
            $table->string('nama_barang', 128);
            $table->decimal('stock', 19, 6);
            $table->decimal('harga', 19, 6);
            $table->decimal('hasil_opname', 19, 6);
            $table->decimal('adjustment', 19, 6);
            $table->timestamps();

            $table->foreign('idh')->references('id')->on('tstockopname_h')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tstockopname_d');
    }
}