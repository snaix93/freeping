<?php

namespace App\Support;

use App\Validation\FqdnValidator;
use App\Validation\IpValidator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Ping
{
    public bool $result;

    public function __construct(public string $connect) { }

    public static function check(string $connect): self
    {
        return tap(new self(Str::of($connect)->trim()->lower()))->ping();
    }

    public function ping()
    {
        $key = md5("ping_{$this->connect}");
        $ttl = now()->addMinutes(5);
        $this->result = Cache::remember($key, $ttl, function () {
            if (IpValidator::isValidPublicIP($this->connect)) {
                return true;
            }

            if (FqdnValidator::isValidPublicFQDN($this->connect)) {
                return true;
            }

            return filter_var($this->connect, FILTER_VALIDATE_URL);
        });
    }

    public function isUnresolvable(): bool
    {
        return ! $this->isResolvable();
    }

    public function isResolvable(): bool
    {
        return $this->result;
    }
}
