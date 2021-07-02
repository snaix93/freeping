<?php

namespace App\Actions;

use App\Actions\WebCheck\DiscoverWebChecks;
use App\Data\MultiCheckDiscoveryResponse;
use App\Support\Nmap\Nmap;
use App\Support\Ping;
use App\Support\UrlParser;
use App\Validation\UrlValidator;
use Illuminate\Pipeline\Pipeline;

class MultiCheckDiscoveryAction
{
    private string $connect;

    public function __invoke(string $connect): MultiCheckDiscoveryResponse
    {
        return resolve(Pipeline::class)
            ->send(new MultiCheckDiscoveryResponse($connect))
            ->through([
                $this->discoverPingCheck(),
                $this->discoverPortChecks(),
                $this->discoverWebChecks(),
            ])
            ->thenReturn();
    }

    private function discoverPingCheck()
    {
        return function (MultiCheckDiscoveryResponse $request, $next) {
            $target = $request->connect;

            if (UrlValidator::isValid($target)) {
                $target = UrlParser::for($target)->host();
            }

            $request
                ->setHasPing(true)
                ->pingResolvable(Ping::check($target)->isResolvable())
                ->setPingTarget($target);

            return $next($request);
        };
    }

    private function discoverPortChecks()
    {
        return function (MultiCheckDiscoveryResponse $request, $next) {
            $target = $request->connect;

            if (UrlValidator::isValid($target)) {
                $target = data_get(parse_url($target), 'host');
            }

            Nmap::create()
                ->scan($target)
                ->openPorts()
                ->whenNotEmpty(fn($ports) => $request
                    ->setHasPorts(true)
                    ->setPorts($ports)
                );

            return $next($request);
        };
    }

    private function discoverWebChecks()
    {
        return function (MultiCheckDiscoveryResponse $response, $next) {

            $discoveredPotentialWebChecks = resolve(DiscoverWebChecks::class)($response->connect);

            if ($discoveredPotentialWebChecks->isEmpty()) {
                $response->setHasWebChecks(false);

                return $next($response);
            }

            $response->setHasWebChecks(true)
                ->setWebChecks($discoveredPotentialWebChecks);

            return $next($response);
        };
    }
}
