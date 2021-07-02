<?php

namespace Database\Factories;

use App\Enums\PingResultStatus;
use App\Models\Node;
use App\Models\PingResult;
use Illuminate\Database\Eloquent\Factories\Factory;

class PingResultFactory extends Factory
{
    protected $model = PingResult::class;

    public function definition()
    {
        return [
            'connect'    => '8.8.8.8',
            'node_id'    => Node::factory(),
            'status'     => PingResultStatus::Alive(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function alive()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => PingResultStatus::Alive(),
            ];
        });
    }

    public function unreachable()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => PingResultStatus::Unreachable(),
            ];
        });
    }

    public function unresolvable()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => PingResultStatus::Unresolvable(),
            ];
        });
    }
}
