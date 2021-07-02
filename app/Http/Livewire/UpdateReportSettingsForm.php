<?php

namespace App\Http\Livewire;

use App\Actions\User\UpdateUserAction;
use App\Data\User\UpdateUserData;
use App\Http\Livewire\Concerns\HasTimePeriods;
use App\Http\Livewire\Concerns\HasTimezones;
use App\Rules\ValidTimePeriod;
use App\Rules\ValidTimeZoneRule;
use Illuminate\Contracts\Auth\Authenticatable;
use Livewire\Component;

class UpdateReportSettingsForm extends Component
{
    use HasTimezones, HasTimePeriods;

    public string $time;

    public string $timezone;

    public function rules()
    {
        return [
            'time'     => [
                'required',
                'string',
                new ValidTimePeriod,
            ],
            'timezone' => [
                'required',
                'string',
                new ValidTimeZoneRule,
            ],
        ];
    }

    public function mount()
    {
        $this->fill([
            'time'     => $this->user->report_time,
            'timezone' => $this->user->report_timezone,
        ]);
    }

    public function updateUserSettings(UpdateUserAction $updateUserAction)
    {
        $this->validate();

        ($updateUserAction)($this->user, new UpdateUserData(
            timezone: $this->timezone,
            time: $this->time,
        ));

        $this->emit('saved');
    }

    public function getUserProperty(): Authenticatable
    {
        return auth()->user();
    }

    public function render()
    {
        return view('livewire.update-report-settings-form');
    }
}
