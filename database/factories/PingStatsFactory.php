<?php

namespace Database\Factories;

use App\Models\Node;
use App\Models\PingStats;
use Illuminate\Database\Eloquent\Factories\Factory;

class PingStatsFactory extends Factory
{
    protected $model = PingStats::class;

    public function definition()
    {
        return [
            'connect'    => $this->faker->ipv4(),
            'node_id'    => Node::factory(),
            'successes'  => $this->faker->numberBetween(0, 10),
            'failures'   => $this->faker->numberBetween(0, 10),
            'errors'     => $this->faker->numberBetween(0, 10),
            'datestamp'  => now(),
            'hour'       => now()->hour,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
