<?php


namespace App\Http\Livewire\Profile;

use Illuminate\Contracts\Auth\Authenticatable;
use Livewire\Component;

class ResetOmcTokenForm extends Component
{
    public string $omc_token;
    public bool $confirmingResetOmcToken = false;

    public function render()
    {
        return view('profile.reset-omc-token-form');
    }

    public function mount()
    {
        session(['omc_token' => $this->user->omc_token]);
        $this->fill([
            'omc_token' => $this->user->omc_token,
        ]);
    }

    public function getUserProperty(): Authenticatable
    {
        return auth()->user();
    }

    public function resetOmcToken(): void
    {
        $this->omc_token = nanoid();
        $this->user->omc_token = $this->omc_token;
        $this->user->save();
        $this->confirmingResetOmcToken = false;
        $this->emit('saved');
    }

    public function confirmResetOmcToken()
    {
        $this->confirmingResetOmcToken = true;
    }

    public function close()
    {
        $this->omc_token = nanoid();
        $this->confirmingResetOmcToken = false;
        $this->emit('saved');
    }
}
