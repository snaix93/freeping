<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;

class CreatePasswordController extends Controller
{
    public function __invoke(ResetUserPassword $resetUserPassword)
    {
        /** @var User $user */
        $resetUserPassword->reset($user = auth()->user(), request()->all());
        $user->markEmailAsVerified();

        session()->flash('flash.banner', 'Password created!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('pingers');
    }
}
