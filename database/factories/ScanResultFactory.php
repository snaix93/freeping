<?php

namespace Database\Factories;

use App\Enums\ScanResultStatus;
use App\Models\Node;
use App\Models\ScanResult;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScanResultFactory extends Factory
{
    protected $model = ScanResult::class;

    public function definition()
    {
        return [
            'connect'    => $this->faker->ipv4(),
            'port'       => random_int(80, 599),
            'node_id'    => Node::factory(),
            'status'     => ScanResultStatus::Open(),
            'reason'     => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
