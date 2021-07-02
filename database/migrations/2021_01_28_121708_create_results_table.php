<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->string('connect')->index();
            $table->uuid('node_id');
            $table->string('status', 20)->nullable();
            $table->tinyInteger('success')->nullable();
            $table->text('error')->nullable();

            $table->timestamps();

            $table->unique(['connect', 'node_id']);
        });
    }
}
