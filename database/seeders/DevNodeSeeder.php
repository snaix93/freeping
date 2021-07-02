<?php

namespace Database\Seeders;

use App\Models\Node;
use Illuminate\Database\Seeder;

class DevNodeSeeder extends Seeder
{
    public function run()
    {
        Node::updateOrInsert([
            'id' => '8ACB46E0-0D06-4EFE-B2A4-A083D66AF83C',
        ], [
            'name'           => 'EU West Germany',
            'short_name'     => 'EU West',
            'country'        => 'eu',
            'url'            => 'dev-pinger-a.freeping.io',
            'request_token'  => 'd3f83d56a08b18c4cb04',
            'callback_token' => '37ede92910d1430f8105c95bac53560d',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
        Node::updateOrInsert([
            'id' => '4982309E-BA09-41CC-BA47-F801F486B93E',
        ], [
            'name'           => 'EU East Poland',
            'short_name'     => 'EU East',
            'country'        => 'eu',
            'url'            => 'dev-pinger-b.freeping.io',
            'request_token'  => 'd3f83d56a08b18c4cb04',
            'callback_token' => '37ede92910d1430f8105c95bac53560d',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
        Node::updateOrInsert([
            'id' => '8786DEF4-1FD5-444C-9BD6-9652C5DCA1D8',
        ], [
            'name'           => 'US West Los Angeles',
            'short_name'     => 'US West',
            'country'        => 'us',
            'url'            => 'dev-pinger-c.freeping.io',
            'request_token'  => 'd3f83d56a08b18c4cb04',
            'callback_token' => '37ede92910d1430f8105c95bac53560d',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
        Node::updateOrInsert([
            'id' => '96C5812B-8007-4D39-99B4-CE92E825765F',
        ], [
            'name'           => 'US East New York',
            'short_name'     => 'US East',
            'country'        => 'us',
            'url'            => 'dev-pinger-d.freeping.io',
            'request_token'  => 'b8c8aea6dbe398846f1821ec',
            'callback_token' => 'ada794807dcb4d6fad197a4ccef56a1a',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    }
}
