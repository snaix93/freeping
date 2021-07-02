<?php

namespace App\Actions\User;

use App\Actions\GetTimeZoneData;
use App\Data\User\UpdateUserData;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class UpdateUserAction
{
    public function __invoke(Authenticatable $user, UpdateUserData $updateUserData): User
    {
        $selectedTimezone = resolve(GetTimeZoneData::class)($updateUserData->timezone);

        return tap($user)->update([
            'report_time'     => $updateUserData->time,
            'report_timezone' => $selectedTimezone['value'],
            'report_offset'   => $selectedTimezone['offset'],
        ]);
    }
}
