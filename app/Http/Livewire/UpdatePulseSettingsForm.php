<?php


namespace App\Http\Livewire;


use App\Actions\User\UpdateUserAction;
use App\Data\User\UpdateUserData;
use Illuminate\Contracts\Auth\Authenticatable;
use Livewire\Component;

class UpdatePulseSettingsForm extends Component
{
    public int $pulse_threshold;
    protected array $messages = [
        'pulse_threshold.gt' => 'Pulse Threshold must be 0 or greater than 299'
    ];

    public function render()
    {
        return view('livewire.update-pulse-settings-form');
    }

    public function mount()
    {
        $this->fill([
            'pulse_threshold' => $this->user->pulse_threshold,
        ]);
    }

    public function getUserProperty(): Authenticatable
    {
        return auth()->user();
    }

    public function updatePulseSettings(): void
    {
        $this->validate();

        $this->user->pulse_threshold = $this->pulse_threshold;
        $this->user->save();
        $this->emit('saved');
    }

    protected function rules()
    {
        if ($this->pulse_threshold === 0) {
            $limit = 'lt:1';
        } else {
            $limit = 'gt:299';
        }
        return [
            'pulse_threshold' => 'required|numeric|' . $limit,
        ];
    }
}
