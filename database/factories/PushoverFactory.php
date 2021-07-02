<?php

namespace Database\Factories;

use App\Enums\PushoverPriority;
use App\Http\Livewire\PushoverRecipient;
use App\Models\Pushover;
use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\Livewire;

class PushoverFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pushover::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

    }

    public function createRecipient()
    {
       return Livewire::test(PushoverRecipient::class)
            ->set([
                'recipient.alerts' => true,
                'recipient.warnings' => true,
                'recipient.recoveries' => true,
                'recipient.meta.priority'  => PushoverPriority::Normal(),
                'recipient.meta.key'  => 'u27j9divtpq88jsy5cuc9xma91u88t',
            ])
            ->call('send');
    }
}
