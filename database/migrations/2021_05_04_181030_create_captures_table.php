<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('captures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('hostname', 255)->index();
            $table->string('capture_id', 255)->index();
            $table->json('measurements');
            $table->timestamp('last_submission_at');
            $table->integer('num_submissions')->nullable();
            $table->text('last_user_agent');
            $table->string('last_remote_address', 255);
            $table->integer('last_content_length');
            $table->integer('last_num_measurements');
            $table->integer('update_interval')->default(0);
            $table->tinyInteger('status')->nullable();
            $table->timestamp('dead_status_reported_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'hostname', 'capture_id']);
            $table->index('user_id');
        });
    }
};
