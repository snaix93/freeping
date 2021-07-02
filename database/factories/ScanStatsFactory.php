<?php

namespace Database\Factories;

use App\Models\Node;
use App\Models\ScanStats;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScanStatsFactory extends Factory
{
    protected $model = ScanStats::class;

    public function definition()
    {
        return [
            'connect'    => $this->faker->ipv4(),
            'port'       => $this->faker->numberBetween(1, 60000),
            'node_id'    => Node::factory(),
            'successes'  => 0,
            'failures'   => 0,
            'datestamp'  => now(),
            'hour'       => now()->hour,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
