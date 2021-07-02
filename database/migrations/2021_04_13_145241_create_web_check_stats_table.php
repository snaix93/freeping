<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('web_check_stats', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->uuid('node_id');
            $table->integer('successes');
            $table->integer('errors');
            $table->date('datestamp');
            $table->unsignedInteger('hour');
            $table->timestamps();
            $table->unique(['uuid', 'node_id', 'datestamp', 'hour']);
        });
    }
};
