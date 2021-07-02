<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name'              => $this->faker->name(),
            'email'             => $this->faker->unique()->safeEmail(),
            'password'          => null,
            'report_time_utc'   => now()->minutes(0)->format('H:i'),
            'report_time'       => now()->minutes(0)->format('H:i'),
            'report_timezone'   => 'Europe/London',
            'report_offset'     => '+00:00',
            'country_code'      => 'GB',
            'user_data'         => null,
            'email_verified_at' => now(),
            'remember_token'    => Str::random(10),
            'omc_token'         => nanoid(),
            'pulse_threshold'   => '300',
            'updated_at'        => now(),
            'created_at'        => now(),
        ];
    }

    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
