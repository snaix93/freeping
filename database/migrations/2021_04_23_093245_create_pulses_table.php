<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePulsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pulses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('hostname', 255);
            $table->text('description')->nullable();
            $table->string('location', 255);
            $table->unsignedTinyInteger('status');
            $table->text('last_user_agent');
            $table->string('last_remote_address', 255);
            $table->timestamp('last_pulse_received_at')->nullable()->index();
            $table->timestamp('alerted_at')->nullable()->index();
            $table->timestamps();
            $table->uuid('event_id')->nullable();
            $table->unique(['user_id', 'hostname']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('host_pulses');
    }
}
