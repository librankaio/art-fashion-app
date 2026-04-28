<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTstockopnameHTable extends Migration
{
    public function up()
    {
        Schema::table('tstockopname_h', function (Blueprint $table) {
            $table->string('status', 32)->nullable()->after('note');
        });
    }

    public function down()
    {
        Schema::table('tstockopname_h', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}