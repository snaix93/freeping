<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJetColumnsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->string('password')->change()->nullable();
            $table->foreignId('current_team_id')->nullable()->after('email_verified_at');
            $table->text('profile_photo_path')->nullable()->after('email_verified_at');
        });
    }
}
