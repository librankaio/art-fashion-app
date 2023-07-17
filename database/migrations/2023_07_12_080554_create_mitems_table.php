<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mitems', function (Blueprint $table) {
            $table->id();
            $table->string('code', 64);
            $table->string('name', 128);
            $table->string('warna', 64);
            $table->string('kategori', 64);
            $table->decimal('hrgjual', $precision = 19, $scale = 6);
            $table->string('size', 64);
            $table->string('satuan', 32);
            $table->string('material', 128);
            $table->decimal('gross', $precision = 19, $scale = 6);
            $table->decimal('nett', $precision = 19, $scale = 6);
            $table->decimal('spcprice', $precision = 19, $scale = 6);
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
        Schema::dropIfExists('mitems');
    }
}
