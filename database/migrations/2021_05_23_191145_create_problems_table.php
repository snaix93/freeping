<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->uuid('event_id')->unique();
            $table->enum('originator', ['Ping', 'WebCheck', 'PortCheck', 'Pulse', 'Capture']);
            $table->enum('severity', ['Alert', 'Warning']);
            $table->string('connect');
            $table->text('description')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('connect');
            $table->index('event_id');
        });
    }
};
