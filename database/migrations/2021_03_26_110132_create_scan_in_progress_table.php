<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScanInProgressTable extends Migration
{
    public function up()
    {
        Schema::create('scan_in_progress', function (Blueprint $table) {
            $table->string('connect');
        });
    }
}
