<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTstockopnameHsTable extends Migration
{
    public function up()
    {
        Schema::create('tstockopname_h', function (Blueprint $table) {
            $table->id();
            $table->string('no', 64);
            $table->date('tanggal');
            $table->string('counter', 64);
            $table->string('note', 256)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tstockopname_h');
    }
}