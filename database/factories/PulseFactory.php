<?php

namespace Database\Factories;

use App\Enums\PulseStatus;
use App\Models\Pulse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PulseFactory extends Factory
{
    protected $model = Pulse::class;

    public function definition()
    {
        return [
            'user_id'                => User::factory(),
            'hostname'               => 'dev.freeping.io',
            'description'            => 'my heartbeat for server',
            'location'               => $this->faker->country,
            'status'                 => PulseStatus::Alive(),
            'last_user_agent'        => $this->faker->userAgent,
            'last_remote_address'    => $this->faker->ipv4(),
            'last_pulse_received_at' => now(),
            'alerted_at'             => null,
            'updated_at'             => now(),
            'created_at'             => now(),
        ];
    }
}
