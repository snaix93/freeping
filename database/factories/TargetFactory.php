<?php

namespace Database\Factories;

use App\Models\Target;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TargetFactory extends Factory
{
    protected $model = Target::class;

    public function definition()
    {
        return [
            'user_id'                        => User::factory(),
            'connect'                        => $this->faker->ipv4(),
            'number_of_recovery_emails_sent' => 0,
            'last_recovery_sent_at'          => null,
            'number_of_alert_emails_sent'    => 0,
            'last_alert_sent_at'             => null,
            'number_of_warning_emails_sent'  => 0,
            'last_warning_sent_at'           => null,
            'updated_at'                     => now(),
            'created_at'                     => now(),
        ];
    }
}
