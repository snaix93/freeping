<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('ping_in_progress', function (Blueprint $table) {
            $table->string('connect')->change();
            $table->renameColumn('connect', 'identifier');
            $table->renameIndex('ping_in_progress_connect_unique', 'ping_in_progress_identifier_unique');
        });
    }
};
