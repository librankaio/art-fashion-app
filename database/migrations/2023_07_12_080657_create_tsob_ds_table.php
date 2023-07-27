<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsobDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tsob_ds', function (Blueprint $table) {
            $table->id();
            $table->integer('idh');
            $table->string('no_sob', 64);
            $table->string('code', 64);
            $table->string('name', 128);
            $table->decimal('qty', $precision = 19, $scale = 6);
            $table->string('satuan', 32);
            $table->decimal('hrgjual', $precision = 19, $scale = 6);
            $table->decimal('subtotal', $precision = 19, $scale = 6);
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
        Schema::dropIfExists('tsob_ds');
    }
}
