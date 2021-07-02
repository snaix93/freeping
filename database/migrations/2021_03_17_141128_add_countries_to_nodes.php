<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddCountriesToNodes extends Migration
{
    public function up()
    {
        if (app()->environment('production')) {
            DB::table('nodes')
                ->where('id', '7724ea64-ed37-43fd-ba45-1150bfdca166')
                ->update(['country' => 'eu']);
            DB::table('nodes')
                ->where('id', 'c351c7e5-138e-4f78-a4e6-ff40e6fe040d')
                ->update(['country' => 'eu']);
            DB::table('nodes')
                ->where('id', 'd78d448d-6f55-4245-8d22-eb91ccc4d344')
                ->update(['country' => 'us']);
            DB::table('nodes')
                ->where('id', '6a3d107e-31a2-4651-b6cc-a641329d2377')
                ->update(['country' => 'us']);
        }
    }
}
