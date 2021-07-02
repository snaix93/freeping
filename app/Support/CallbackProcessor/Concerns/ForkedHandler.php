<?php

namespace App\Support\CallbackProcessor\Concerns;

use App\Support\CallbackProcessor\Data\Payload;
use App\Support\CallbackProcessor\Data\PingPayload;
use App\Support\CallbackProcessor\Enums\JobType;

trait ForkedHandler
{
    public function handleByJobType(Payload $payload)
    {
        $lookup = [
            JobType::Ping     => fn($payload) => $this->handlePing($payload),
            JobType::Scan     => fn($payload) => $this->handleScan($payload),
            JobType::WebCheck => fn($payload) => $this->handleWebCheck($payload),
        ];

        return $lookup[$payload->jobType->value]($payload);
    }

    abstract protected function handlePing(PingPayload $pingPayload);

    abstract protected function handleScan(Payload $payload);

    abstract protected function handleWebCheck(Payload $payload);
}
