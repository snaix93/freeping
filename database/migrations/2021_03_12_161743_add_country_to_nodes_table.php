<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryToNodesTable extends Migration
{
    public function up()
    {
        Schema::table('nodes', function (Blueprint $table) {
            $table->string('country')->nullable()->after('short_name');
        });
    }
}
