<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeTargetStatusesToNewInts extends Migration
{
    public function up()
    {
        DB::table('targets')
            ->where('status', 4)
            ->update(['status' => 3]);
    }
}
