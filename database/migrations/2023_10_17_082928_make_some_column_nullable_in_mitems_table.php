<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeSomeColumnNullableInMitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mitems', function (Blueprint $table) {
            //
            $table->string('kategori', 64)->nullable()->change();
            $table->decimal('hrgjual', $precision = 19, $scale = 6)->nullable()->change();
            $table->string('size', 64)->nullable()->change();
            $table->string('material', 128)->nullable()->change();
            $table->decimal('nett', $precision = 19, $scale = 6)->nullable()->change();
            $table->decimal('spcprice', $precision = 19, $scale = 6)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mitems', function (Blueprint $table) {
            //
        });
    }
}
