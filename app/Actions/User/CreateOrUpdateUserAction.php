<?php

namespace App\Actions\User;

use App\Data\User\CreateUserData;
use App\Data\User\UpdateUserData;
use App\Models\User;

class CreateOrUpdateUserAction
{
    public function __construct(
        private CreateUserAction $createUserAction,
        private UpdateUserAction $updateUserAction,
    ) { }

    public function __invoke(CreateUserData $createUserData): User
    {
        $user = User::whereEmail($createUserData->email)->first();

        if (is_null($user)) {
            $user = ($this->createUserAction)($createUserData);
        } else {
            $user = ($this->updateUserAction)($user, new UpdateUserData(
                timezone: $createUserData->timezone,
                time: $createUserData->time,
            ));
        }

        return $user;
    }
}
