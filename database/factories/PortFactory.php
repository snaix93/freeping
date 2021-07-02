<?php

namespace Database\Factories;

use App\Models\Port;
use App\Models\Target;
use App\Models\User;
use Composer\Util\Tar;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortFactory extends Factory
{
    protected $model = Port::class;

    public function definition()
    {
        return [
            'user_id'              => User::factory(),
            'target_id'            => Target::factory(),
            'connect'              => $this->faker->ipv4(),
            'port'                 => $this->faker->numberBetween(1, 60000),
            'status'               => null,
            'nodes_down'           => null,
            'number_of_recoveries' => 0,
            'last_recovery_at'     => null,
            'number_of_alerts'     => 0,
            'last_alert_at'        => null,
            'number_of_warnings'   => 0,
            'last_warning_at'      => null,
            'created_at'           => now(),
            'updated_at'           => now(),
        ];
    }
}
