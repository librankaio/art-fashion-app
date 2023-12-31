<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrcvHsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trcv_hs', function (Blueprint $table) {
            $table->id();
            $table->string('no', 64);
            $table->date('tgl');
            $table->string('counter', 64);
            $table->string('no_sj', 64);
            $table->string('note', 256)->nullable();
            $table->string('user', 64);
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
        Schema::dropIfExists('trcv_hs');
    }
}
