<?php

namespace App\Actions\Fortify;

use App\Actions\GetUserTimezoneData;
use App\Actions\User\CreateUserAction;
use App\Data\User\CreateUserData;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input)
    {
        Validator::make($input, [
            'email'     => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password'  => $this->passwordRules(),
            'terms'     => ['accepted'],
        ])->validate();

        return tap(resolve(CreateUserAction::class)(new CreateUserData(
            email: $input['email'],
            timezone: value($timezoneData = (resolve(GetUserTimezoneData::class)()))->timezone,
            time: $timezoneData->currentTime->floorHour()->format('H:i'),
            password: $input['password'],
        )), function (User $user) use ($input) {
            $user->sendEmailVerificationNotification();
        });
    }
}
