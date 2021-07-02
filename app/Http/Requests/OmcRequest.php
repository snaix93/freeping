<?php

namespace App\Http\Requests;

use App\Caches\CacheKey;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

abstract class OmcRequest extends FormRequest
{
    /**
     * Get the User of the OMC token or abort the request with 401 unauthorized
     *
     * @return int
     * @throws \Exception
     */
    public function getUserId(): int
    {
        $omcToken = $this->header('omc-token');
        $cacheKey = CacheKey::userByOmcToken($omcToken);
        if ($userId = cache($cacheKey)) {
            Log::debug('OMC Request authenticated from cache. '.$cacheKey);

            return $userId;
        }
        $user = User::byOmcToken($omcToken);
        abort_unless($user, response()->json([
            'success' => false,
            'error'   => 'bad token',
        ], 401));
        if (is_null($user->email_verified_at)) {
            abort(response()->json([
                'success' => false,
                'error'   => 'account not verified. check your emails.',
            ], 401));
        }
        cache([$cacheKey => (int) $user->id], 3600);
        Log::debug('OMC Request authenticated from database.');

        return $user->id;
    }

    public function __destruct()
    {
        Log::debug("OMC Request processed.", [$this->input('hostname'), $this->userAgent()]);
    }

    /**
     * Custom Failed Response
     *
     * Overrides the Illuminate\Foundation\Http\FormRequest
     * response function to stop it from auto redirecting
     * and applies a API custom response format.
     *
     */
    protected function failedValidation(Validator $validator)
    {
        abort(response()->json([
            'success' => false,
            'error'   => $validator->errors(),
        ], 422, [], JSON_PRETTY_PRINT));
    }
}
