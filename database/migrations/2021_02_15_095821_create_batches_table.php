<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesTable extends Migration
{
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->uuid('id')->index();
            $table->uuid('node_id');
            $table->integer('checks_dispatched')
                ->comment('Number of checks sent to pinger node');
            $table->integer('results_received')
                ->default(0)
                ->comment('Number of check results received from check node');
            $table->timestamp('finished_at')
                ->nullable()
                ->comment('datetime when a pinger nodes has sent back results');

            $table->timestamps();
        });
    }
}
