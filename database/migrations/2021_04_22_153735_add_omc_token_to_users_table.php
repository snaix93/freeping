<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddOmcTokenToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->after('remember_token', function ($table) {
                $table->char('omc_token', 21)->nullable()->unique();
                $table->unsignedInteger('pulse_threshold')->default(300);
            });
        });

        DB::table('users')->whereNull('omc_token')->lazyById()->each(function ($user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update(['omc_token' => nanoid()]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('omc_token', 21)->nullable(false)->change();
        });
    }
}
