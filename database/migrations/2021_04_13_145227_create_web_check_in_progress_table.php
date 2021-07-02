<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('web_check_in_progress', function (Blueprint $table) {
            $table->string('identifier')->unique();
        });
    }
};
