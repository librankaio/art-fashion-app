<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMhakaksesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mhakakses', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->string('nik', 64);
            $table->string('counter', 128);
            $table->string('feature', 128);
            $table->string('save', 2)->nullable();
            $table->string('open', 2)->nullable();
            $table->string('updt', 2)->nullable();
            $table->string('print', 2)->nullable();
            $table->string('dlt', 2)->nullable();
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
        Schema::dropIfExists('mhakakses');
    }
}
