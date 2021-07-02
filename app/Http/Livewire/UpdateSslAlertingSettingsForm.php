<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Auth\Authenticatable;
use Livewire\Component;

class UpdateSslAlertingSettingsForm extends Component
{
    public int $sslAlertThreshold;
    public int $sslWarningThreshold;

    protected $rules = [
        'sslAlertThreshold' => 'required|numeric',
        'sslWarningThreshold' => 'required|numeric',
    ];

    public function render()
    {
        return view('livewire.update-ssl-alerting-settings-form');
    }

    public function mount()
    {
        $this->fill([
            'sslAlertThreshold'   => $this->user->ssl_alert_threshold,
            'sslWarningThreshold' => $this->user->ssl_warning_threshold,
        ]);
    }

    public function updateSslAlertingSettings(): void
    {
        $this->validate();

        $this->user->ssl_alert_threshold = $this->sslAlertThreshold;
        $this->user->ssl_warning_threshold = $this->sslWarningThreshold;
        $this->user->save();
        $this->emit('saved');
    }

    public function getUserProperty(): Authenticatable
    {
        return auth()->user();
    }
}
