<?php

use App\Enums\PortStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortsTable extends Migration
{
    public function up()
    {
        Schema::create('ports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('target_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('connect', 253)->index();
            $table->unsignedInteger('port')->index();

            $table->tinyInteger('status')->default(PortStatus::Open);
            $table->json('nodes_down')->nullable();

            $table->integer('number_of_recoveries')->default(0);
            $table->timestamp('last_recovery_at')->nullable();

            $table->integer('number_of_alerts')->default(0);
            $table->timestamp('last_alert_at')->nullable();

            $table->integer('number_of_warnings')->default(0);
            $table->timestamp('last_warning_at')->nullable();

            $table->timestamps();
        });
    }
}
