<?php /** @noinspection LaravelFunctionsInspection */

namespace Database\Seeders;

use App\Enums\PortStatus;
use App\Models\Node;
use App\Models\PingStats;
use App\Models\Port;
use App\Models\Pulse;
use App\Models\ScanStats;
use App\Models\Target;
use App\Models\User;
use App\Models\WebCheck;
use App\Support\UrlParser;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    private $targets = [
        ['connect' => '1.1.1.1'],
        ['connect' => '8.8.8.8'],
        ['connect' => 'fake.fake.com'],
        ['connect' => '123.123.123.123'],
        ['connect' => 'ping-dev.flapping.tinyserver.net'],
        ['connect' => 'ping-dev.chaos.tinyserver.net'],
    ];

    private $webChecks = [
        ['url' => 'https://webcheck-dev.chaos.tinyserver.net'],
        ['url' => 'https://cloudradar.io'],
        ['url' => 'https://expired.badssl.com'],
        ['url' => 'http://webcheck-dev.chaos.tinyserver.net'],
        ['url' => 'http://webcheck-dev-complex.chaos.tinyserver.net:80/path?query=hello'],
    ];

    private $pulses = [
        ['hostname' => 'dev.freeping.io'],
        ['hostname' => 'freeping.io'],
        ['hostname' => 'dev1.freeping.io'],
        ['hostname' => 'dev2.freeping.io'],
        ['hostname' => 'dev4.freeping.io'],
    ];

    public function run()
    {
        User::factory()
            ->has(Target::factory()
                ->count(count($this->targets))
                ->state(new Sequence(...$this->targets))
                ->afterCreating(function (Target $target) {
                    $this->createPortsForTarget($target);
                    $this->createPingStats($target);
                }))
            ->has(WebCheck::factory()
                ->count(count($this->webChecks))
                ->state(new Sequence(...collect($this->webChecks)->map(function ($item) {
                    $parser = UrlParser::for($item['url']);

                    return array_merge($item, [
                        'protocol' => $parser->protocol(),
                        'host'     => $parser->host(),
                        'port'     => $parser->port(),
                        'path'     => $parser->path(),
                        'query'    => $parser->query(),
                        'fragment' => $parser->fragment(),
                    ]);
                })))
                ->afterCreating(function (WebCheck $webCheck) {
                    $this->createWebCheckStats($webCheck);
                }))
            ->has(Pulse::factory()
                ->count(count($this->pulses))
                ->state(new Sequence(...collect($this->pulses)->map(function ($item) {
                    return array_merge($item, [
                        'description' => 'my pulse for '.$item['hostname'],
                    ]);
                })))
            )
            ->create([
                'name'     => env('SEED_NAME'),
                'email'    => env('SEED_EMAIL'),
                'password' => Hash::make('12345678'),
            ]);
    }

    private function createPortsForTarget(Target $target)
    {
        Port::factory()
            ->afterCreating(function (Port $port) {
                $this->createScanStats($port);
            })
            ->createMany(
                collect(range(1, 3))->map(fn() => [
                    'status'     => PortStatus::AwaitingResult,
                    'connect'    => $target->connect,
                    'user_id'    => $target->user_id,
                    'target_id'  => $target->id,
                    'created_at' => now()->subDay()->endOfDay(),
                    'updated_at' => now()->subDay()->endOfDay(),
                ])->all()
            );
    }

    private function createScanStats(Port $port)
    {
        ScanStats::factory()->createMany(
            Node::all()->flatMap(function (Node $node) use ($port) {
                return collect(range(1, 24))->map(fn($hour) => [
                    'connect'    => $port->target->connect,
                    'port'       => $port->port,
                    'node_id'    => $node->id,
                    'successes'  => random_int(0, 10),
                    'failures'   => random_int(0, 10),
                    'datestamp'  => now()->subDay(),
                    'hour'       => $hour,
                    'created_at' => now()->subDay()->endOfDay(),
                    'updated_at' => now()->subDay()->endOfDay(),
                ]);
            })->all()
        );
    }

    private function createPingStats(Target $target)
    {
        PingStats::factory()->createMany(
            Node::all()->flatMap(function (Node $node) use ($target) {
                return collect(range(1, 24))->map(fn($hour) => [
                    'connect'    => $target->connect,
                    'node_id'    => $node->id,
                    'successes'  => random_int(0, 10),
                    'failures'   => random_int(0, 10),
                    'errors'     => random_int(0, 10),
                    'datestamp'  => now()->subDay(),
                    'hour'       => $hour,
                    'created_at' => now()->subDay()->endOfDay(),
                    'updated_at' => now()->subDay()->endOfDay(),
                ]);
            })->all()
        );
    }

    private function createWebCheckStats(WebCheck $webCheck)
    {
        // PingStats::factory()->createMany(
        //     Node::all()->flatMap(function (Node $node) use ($target) {
        //         return collect(range(1, 24))->map(fn($hour) => [
        //             'connect'    => $target->connect,
        //             'node_id'    => $node->id,
        //             'successes'  => random_int(0, 10),
        //             'failures'   => random_int(0, 10),
        //             'errors'     => random_int(0, 10),
        //             'datestamp'  => now()->subDay(),
        //             'hour'       => $hour,
        //             'created_at' => now()->subDay()->endOfDay(),
        //             'updated_at' => now()->subDay()->endOfDay(),
        //         ]);
        //     })->all()
        // );
    }
}
