<?php

use App\Enums\TargetStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDefaultTargetStatusOnTargetsTable extends Migration
{
    public function up()
    {
        Schema::table('targets', function (Blueprint $table) {
            $table->unsignedSmallInteger('status')->default(TargetStatus::AwaitingResult)->change();
        });
    }
}
