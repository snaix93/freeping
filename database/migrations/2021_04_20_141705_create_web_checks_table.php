<?php

use App\Enums\WebCheckStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('web_checks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('url');
            $table->string('method');
            $table->unsignedSmallInteger('expected_http_status');
            $table->unsignedTinyInteger('search_html_source')->nullable();
            $table->string('expected_pattern')->nullable();
            $table->json('headers')->nullable();

            $table->unsignedSmallInteger('status')->default(WebCheckStatus::AwaitingResult);
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
};
