<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('captures', function (Blueprint $table) {
            $table->after('last_num_measurements', function ($table) {
               $table->json('last_alerts')->nullable();
               $table->json('last_warnings')->nullable();
               $table->json('last_defects')->nullable();
            });
            $table->integer('update_interval')->nullable()->change();
        });
    }
};
