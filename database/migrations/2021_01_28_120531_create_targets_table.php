<?php

use App\Enums\TargetStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetsTable extends Migration
{
    public function up()
    {
        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('connect', 253)->index();

            $table->tinyInteger('status')->default(TargetStatus::Online);
            $table->json('nodes_down')->nullable();

            $table->integer('number_of_recovery_emails_sent')->default(0);
            $table->timestamp('last_recovery_sent_at')->nullable();

            $table->integer('number_of_alert_emails_sent')->default(0);
            $table->timestamp('last_alert_sent_at')->nullable();

            $table->integer('number_of_warning_emails_sent')->default(0);
            $table->timestamp('last_warning_sent_at')->nullable();

            $table->timestamps();
        });
    }
}
