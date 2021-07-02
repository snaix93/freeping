<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->after('pulse_threshold', function ($table) {
                $table->unsignedInteger('ssl_alert_threshold')->default(2);
                $table->unsignedInteger('ssl_warning_threshold')->default(7);
            });
        }
        );
    }
};
