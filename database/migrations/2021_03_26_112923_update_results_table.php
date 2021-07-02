<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateResultsTable extends Migration
{
    public function up()
    {
        Schema::rename('results', 'ping_results');
    }
}
