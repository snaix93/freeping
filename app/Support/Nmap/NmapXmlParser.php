<?php

namespace App\Support\Nmap;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use SimpleXMLElement;

class NmapXmlParser
{
    public static function parseOutputFile($xmlFile): ?Host
    {
        $xml = simplexml_load_file($xmlFile);

        if (! static::hostIsReachable($xml)) {
            return new Host('unreachable');
        }

        $host = $xml->host[0];

        return new Host(
            (string) $host->status->attributes()->state,
            ...self::parsePorts($host->ports->port),
        );
    }

    private static function hostIsReachable(SimpleXMLElement $xml): bool
    {
        if ((bool) (int) $xml->runstats->hosts->attributes()->up) {
            return true;
        }

        return false;
    }

    public static function parsePorts(SimpleXMLElement $xmlPorts): Collection
    {
        $ports = collect();
        foreach ($xmlPorts as $port) {
            if (is_null($attrs = $port->attributes())) {
                continue;
            }

            $ports->push(new Port(
                number: (int) $attrs->portid,
                protocol: (string) $attrs->protocol,
                state: (string) $port->state->attributes()->state,
                reason: (string) $port->state->attributes()->reason,
                service: Str::upper($port?->service?->attributes()?->name)
            ));
        }

        return $ports;
    }
}
