<?php

namespace App\Actions\User;

use App\Actions\GetTimeZoneData;
use App\Actions\GetUserTimezoneData;
use App\Data\User\CreateUserData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    public function __invoke(CreateUserData $createUserData): User
    {
        $locationData = resolve(GetUserTimezoneData::class)();
        $selectedTimezone = resolve(GetTimeZoneData::class)($createUserData->timezone);

        return User::create([
            'email'              => $createUserData->email,
            'password'           => ! is_null($createUserData->password)
                ? Hash::make($createUserData->password)
                : null,
            'report_time'        => $createUserData->time,
            'report_timezone'    => $selectedTimezone['value'],
            'report_offset'      => $selectedTimezone['offset'],
            'country_code'       => $locationData->countryCode,
            'user_data'          => json_encode($locationData->data),
            'registration_track' => session()->pull('utm'),
        ]);
    }
}
