<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterScanResultsTable extends Migration
{
    public function up()
    {
        Schema::table('scan_results', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->renameColumn('success', 'status');
        });
    }
}
