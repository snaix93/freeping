<?php

namespace Database\Factories;

use App\Enums\WebCheckStatus;
use App\Models\User;
use App\Models\WebCheck;
use App\Support\UrlParser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class WebCheckFactory extends Factory
{
    protected $model = WebCheck::class;

    public function definition()
    {
        $urlParser = UrlParser::for($this->faker->url);

        return [
            'uuid'                 => Str::uuid(),
            'user_id'              => User::factory(),
            'url'                  => $urlParser->url(),
            'protocol'             => $urlParser->protocol(),
            'host'                 => $urlParser->host(),
            'port'                 => $urlParser->port(),
            'path'                 => $urlParser->path(),
            'query'                => $urlParser->query(),
            'fragment'             => $urlParser->fragment(),
            'method'               => 'GET',
            'expected_http_status' => 200,
            'search_html_source'   => null,
            'expected_pattern'     => null,
            'headers'              => null,
            'status'               => WebCheckStatus::AwaitingResult,
            'nodes_down'           => null,
            'number_of_recoveries' => 0,
            'last_recovery_at'     => null,
            'number_of_alerts'     => 0,
            'last_alert_at'        => null,
            'number_of_warnings'   => 0,
            'last_warning_at'      => null,
            'created_at'           => now(),
            'updated_at'           => now(),
        ];
    }
}
