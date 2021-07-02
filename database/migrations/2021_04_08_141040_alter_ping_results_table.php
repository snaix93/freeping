<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterPingResultsTable extends Migration
{
    public function up()
    {
        Schema::table('ping_results', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->renameColumn('error', 'reason');
            $table->renameColumn('success', 'status');
        });
    }
}
