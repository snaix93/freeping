<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClearOutUserPasswords extends Migration
{
    public function up()
    {
        if (app()->environment('production')) {
            DB::table('users')->update(['password' => null]);
        }
    }
}
