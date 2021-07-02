<?php

namespace App\Providers;

use App\Actions\GetUserTimezoneData;
use App\Models\Pulse;
use App\Models\Target;
use App\Models\User;
use App\Models\WebCheck;
use App\Policies\PulsePolicy;
use App\Policies\TargetPolicy;
use App\Policies\WebCheckPolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Lukeraymonddowning\Honey\Facades\Honey;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Target::class   => TargetPolicy::class,
        WebCheck::class => WebCheckPolicy::class,
        Pulse::class    => PulsePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        VerifyEmailNotification::createUrlUsing(function ($user) {
            return URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id'   => $user->getRouteKey(),
                    'hash' => sha1($user->getEmailForVerification()),
                ]
            );
        });

        Honey::failUsing(function () {
            abort(403,
                'You access has been restricted. If you feel this is a mistake please get in touch with us at '.config('mail.from.address'));
        });

        Gate::define('user-country', function (?User $user = null) {
            $countryCode = (resolve(GetUserTimezoneData::class)())->countryCode;

            return in_array($countryCode, config('blocked-countries'))
                ? Response::deny('Sorry. The service is not available in your country.')
                : Response::allow();
        });
    }
}
