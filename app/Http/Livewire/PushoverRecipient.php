<?php

namespace App\Http\Livewire;

use App\Models\Pushover;
use App\Notifications\PushoverActivatedNotification;
use Illuminate\Contracts\Auth\Authenticatable;
use Livewire\Component;

class PushoverRecipient extends Component
{
    public Pushover $pushover;

    protected $validationAttributes = [
        'meta.key'      => 'key',
        'meta.priority' => 'priority',
    ];

    protected $rules = [
        'pushover.alerts'        => 'required|boolean',
        'pushover.warnings'      => 'required|boolean',
        'pushover.recoveries'    => 'required|boolean',
        'pushover.meta.key'      => 'required|size:30',
        'pushover.meta.priority' => 'required|integer',
    ];

    public function mount()
    {
        $this->pushover = $this->user->pushoverRecipient;
    }

    public function render()
    {
        return view('livewire.pushover-recipient');
    }

    public function save()
    {
        $this->validate();

        $this->pushover->user_id = $this->user->id;
        if ($this->pushover->save()) {
            $this->emit('saved');
        }

        if ($this->pushover->wasRecentlyCreated) {
            $this->user->notify(new PushoverActivatedNotification);
        }
    }

    public function delete()
    {
        if ($this->pushover->delete()) {
            $this->emit('deleted');
        }
    }

    public function getUserProperty(): Authenticatable
    {
        return auth()->user();
    }
}
