<?php

namespace App\Http\Livewire\Concerns;

use App\Support\Backdoor;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Illuminate\Validation\ValidationException;

trait WithRateLimiting
{
    use \DanHarrin\LivewireRateLimiting\WithRateLimiting {
        rateLimit as traitRateLimit;
    }

    /** @noinspection PhpRedundantCatchClauseInspection */
    public function rateLimit($maxAttempts, $decaySeconds = 60)
    {
        if (Backdoor::isOpen()) {
            return;
        }
        
        try {
            $this->traitRateLimit($maxAttempts, $decaySeconds);
        } catch (TooManyRequestsException $exception) {
            $this->clearValidation();

            throw ValidationException::withMessages([
                'pingTarget' => __(
                    'Slow down! Please wait another :seconds seconds.',
                    ['seconds' => $exception->secondsUntilAvailable]
                ),
            ]);
        }
    }
}
