<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreturDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tretur_ds', function (Blueprint $table) {
            $table->id();
            $table->integer('idh');
            $table->string('no_retur', 64);
            $table->string('code', 64);
            $table->string('name', 128);
            $table->integer('qty');
            $table->string('satuan', 32);
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
        Schema::dropIfExists('tretur_ds');
    }
}
