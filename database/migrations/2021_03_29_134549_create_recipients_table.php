<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipientsTable extends Migration
{
    public function up()
    {
        Schema::create('recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('type')->index();
            $table->boolean('alerts')->default(0);
            $table->boolean('warnings')->default(0);
            $table->boolean('recoveries')->default(0);
            $table->schemalessAttributes('meta');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }
}
