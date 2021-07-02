<?php

namespace App\Validation;

use Illuminate\Support\Str;

class FqdnValidator extends ConnectValidator
{
    public static function isValidPrivate($input): bool
    {
        if (! self::isValid($input)) {
            return false;
        }

        return ! self::isValidPublicFQDN($input);
    }

    public static function isValid($input): bool
    {
        $input = static::getInput($input);

        if (! str_contains($input, '.')) {
            return false;
        }

        if (is_numeric(str_replace('.', '', $input))) {
            return false;
        }

        if (
            preg_match("/^([a-z\d]([-_]*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $input)
            && preg_match('/^.{1,253}$/', $input)
            && preg_match("/^[^.]{1,63}(\.[^.]{1,63})*$/", $input)) {
            return true;
        }

        return false;
    }

    public static function isValidPublicFQDN($input): bool
    {
        if (! self::isValid($input)) {
            return false;
        }

        if (preg_match("/\.local$/i", $input)) {
            return false;
        }

        return self::isResolvable($input);
    }

    private static function isResolvable(string $connect): bool
    {
        $connect = static::getInput($connect);

        if ((string) Str::of(gethostbyname($connect))->lower()->trim() !== $connect) {
            return true;
        }

        exec(sprintf("host -W 2 %s", $connect), $output, $statusCode);

        if ($statusCode === 0) {
            return true;
        }

        return false;
    }
}
