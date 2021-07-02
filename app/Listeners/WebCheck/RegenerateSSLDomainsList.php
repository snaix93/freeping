<?php


namespace App\Listeners\WebCheck;


use App\Actions\SslCheck\RegenerateSslDomainListAction;
use App\Events\WebCheck\AbstractWebCheckEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegenerateSSLDomainsList implements ShouldQueue
{
    public function handle(AbstractWebCheckEvent $webCheckEvent)
    {
        resolve(RegenerateSslDomainListAction::class)($webCheckEvent->webCheck);
    }
}
