<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNodesTable extends Migration
{
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->uuid('id')->index();
            $table->string('name');
            $table->string('short_name');
            $table->string('url');
            $table->string('request_token');
            $table->string('callback_token');
            $table->timestamps();
        });
    }
}
