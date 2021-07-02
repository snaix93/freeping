<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScanResultsTable extends Migration
{
    public function up()
    {
        Schema::create('scan_results', function (Blueprint $table) {
            $table->id();
            $table->string('connect')->index();
            $table->unsignedInteger('port')->index();
            $table->uuid('node_id');
            $table->string('status', 20)->nullable();
            $table->tinyInteger('success')->nullable();
            $table->text('reason')->nullable();

            $table->timestamps();

            $table->unique(['connect', 'port', 'node_id']);
        });
    }
}
