<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePingInProgress extends Migration
{
    public function up()
    {
        Schema::create('ping_in_progress', function (Blueprint $table) {
            $table->string('connect', 253)->unique();
        });
    }
}
