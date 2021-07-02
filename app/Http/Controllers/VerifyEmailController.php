<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        abort_if(
            is_null($user = User::findByOId($request->route('id'))),
            404
        );
        abort_unless(
            hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification())),
            403
        );

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(config('home').'?verified=1');
        }

        $user->markEmailAsVerified();

        return redirect()->intended(config('home').'?verified=1');
    }
}
