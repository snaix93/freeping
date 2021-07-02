<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScanStatsTable extends Migration
{
    public function up()
    {
        Schema::create('scan_stats', function (Blueprint $table) {
            $table->id();
            $table->string('connect', 253)->index();
            $table->unsignedInteger('port');
            $table->uuid('node_id');
            $table->integer('successes');
            $table->integer('failures');
            $table->date('datestamp');
            $table->unsignedInteger('hour');
            $table->timestamps();
            $table->unique(['connect', 'port', 'node_id', 'datestamp', 'hour']);
        });
    }
}
