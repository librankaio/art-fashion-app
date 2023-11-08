<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMitemCounterUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mitem_counter_uploads', function (Blueprint $table) {
            $table->id();
            $table->date('tgl');
            $table->string('code_mitem', 64);
            $table->string('name_mitem', 128);
            $table->string('code_mcounter', 128);
            $table->string('name_mcounter', 128);
            $table->decimal('qty', $precision = 19, $scale = 6);
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
        Schema::dropIfExists('mitem_counter_uploads');
    }
}
