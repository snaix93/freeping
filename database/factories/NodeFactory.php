<?php

namespace Database\Factories;

use App\Models\Node;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NodeFactory extends Factory
{
    protected $model = Node::class;

    public function definition()
    {
        return [
            'id'             => Str::uuid()->toString(),
            'name'           => $this->faker->city(),
            'short_name'     => Str::title($this->faker->unique()->citySuffix()),
            'url'            => 'dev-pinger-a.freeping.io',
            'request_token'  => 'eeNgeneg1ooP',
            'callback_token' => 'loiqu1de6Cooth4ZieBiegaib0woh1hu',
            'created_at'     => now(),
            'updated_at'     => now(),
        ];
    }
}
