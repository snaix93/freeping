<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePingStats extends Migration
{
    public function up()
    {
        Schema::create('ping_stats', function (Blueprint $table) {
            $table->id();
            $table->string('connect', 253)->index();
            $table->uuid('node_id');
            $table->integer('successes')->comment('Counter of successful pings');
            $table->integer('failures')->comment('Counter of unsuccessful pings');
            $table->integer('errors')->comment('Counter of errors');
            $table->date('datestamp');
            $table->unsignedInteger('hour');
            $table->timestamps();
            $table->unique(['connect', 'node_id', 'datestamp', 'hour']);
        });
    }
}
