<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('web_check_results', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->uuid('node_id');
            $table->tinyInteger('status')->nullable();
            $table->text('reason')->nullable();

            $table->timestamps();
            $table->unique(['uuid', 'node_id']);
        });
    }
};
