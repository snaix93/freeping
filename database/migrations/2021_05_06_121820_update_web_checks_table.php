<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('web_checks', function (Blueprint $table) {
            $table->after('url', function ($table) {
                $table->string('protocol');
                $table->string('host');
                $table->unsignedSmallInteger('port')->nullable();
                $table->string('path')->nullable();
                $table->string('query')->nullable();
                $table->string('fragment')->nullable();
            });
        });
    }
};
