<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Http\Livewire\Concerns;

use App\Collections\WebCheckDataCollection;
use App\Data\WebCheck\WebCheckData;
use App\Support\UrlParser;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

trait WithWebChecks
{
    public ?array $webChecks = null;

    public $includeWebChecks = false;

    public function rulesWithWebChecks()
    {
        return [
            'webChecks'                   => [
                'nullable',
                'array',
            ],
            'webChecks.*.active'          => [
                'sometimes',
                'bool',
            ],
            'webChecks.*.url'             => [
                'sometimes',
                'string',
                'max:255',
            ],
            'webChecks.*.protocol'        => [
                'sometimes',
                'string',
                Rule::in(['http', 'https']),
            ],
            'webChecks.*.host'            => [
                'sometimes',
                'string',
            ],
            'webChecks.*.port'            => [
                'sometimes',
                'nullable',
                'int',
            ],
            'webChecks.*.path'            => [
                'sometimes',
                'nullable',
                'string',
            ],
            'webChecks.*.query'           => [
                'sometimes',
                'nullable',
                'string',
            ],
            'webChecks.*.fragment'        => [
                'sometimes',
                'nullable',
                'string',
            ],
            'webChecks.*.method'          => [
                'sometimes',
                'string',
                Rule::in(['GET']),
            ],
            'webChecks.*.expectedStatus'  => [
                'sometimes',
                'integer',
            ],
            'webChecks.*.expectedPattern' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],
            'webChecks.*.searchSource'    => [
                'sometimes',
                'nullable',
                'bool',
            ],
            'webChecks.*.headers'         => [
                'sometimes',
                'nullable',
                'array',
            ],
            'webChecks.*.headers.*.key'   => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],
            'webChecks.*.headers.*.value' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    public function messagesWithWebChecks()
    {
        return [
            'webChecks.*.method.url' => 'Must be a valid url.',
            'webChecks.*.method.in'  => 'Web checks can only check GET method currently.',
        ];
    }

    public function validationAttributesWithWebChecks()
    {
        return [
            'webChecks.*.active'          => 'web check',
            'webChecks.*.url'             => 'url',
            'webChecks.*.protocol'        => 'protocol',
            'webChecks.*.host'            => 'host',
            'webChecks.*.port'            => 'port',
            'webChecks.*.path'            => 'path',
            'webChecks.*.query'           => 'query',
            'webChecks.*.fragment'        => 'fragment',
            'webChecks.*.method'          => 'method',
            'webChecks.*.expectedStatus'  => 'status',
            'webChecks.*.searchSource'    => 'search source',
            'webChecks.*.headers.*.key'   => 'header key',
            'webChecks.*.headers.*.value' => 'header value',
        ];
    }

    public function resetWebChecks()
    {
        $this->reset('webChecks');
        $this->resetValidation('webChecks');

        return $this;
    }

    public function addHeader($webCheckKey)
    {
        $this->setWebChecks(collect($this->webChecks)->map(function ($check, $key) use ($webCheckKey) {
            if ($key === $webCheckKey) {
                $check['headers'] = Arr::add($check['headers'], Str::random(), [
                    'key'   => null,
                    'value' => null,
                ]);
            }

            return $check;
        }));
    }

    protected function setWebChecks(null|Collection|array $webChecks)
    {
        $this->syncInput('webChecks',
            collect()->wrap($this->webChecks ?? [])->merge($webChecks)->all()
        );
    }

    public function removeHeader($webCheckKey, $headerIndex)
    {
        $this->setWebChecks(collect($this->webChecks)->map(function ($check, $key) use ($headerIndex, $webCheckKey) {
            if ($key === $webCheckKey) {
                unset($check['headers'][$headerIndex]);
            }

            return $check;
        }));
    }

    public function addCheck($url)
    {
        $this->makeWebChecksFromUrls($url);
    }

    public function makeWebChecksFromUrls(null|string|array|Collection $urls)
    {
        if (is_null($urls)) {
            return;
        }

        $this->setWebChecks(collect()->wrap($urls)->mapWithKeys(function ($url) {
            $urlParser = UrlParser::for($url);

            return [
                (string) Str::orderedUuid() => [
                    'url'             => $urlParser->url(),
                    'protocol'        => $urlParser->protocol(),
                    'host'            => $urlParser->host(),
                    'port'            => $urlParser->port(),
                    'path'            => $urlParser->path(),
                    'query'           => $urlParser->query(),
                    'fragment'        => $urlParser->fragment(),
                    'active'          => true,
                    'method'          => 'GET',
                    'expectedStatus'  => 200,
                    'expectedPattern' => null,
                    'searchSource'    => false,
                    'headers'         => [],
                ],
            ];
        }));
    }

    public function updatedWithWebChecks($name)
    {
        if (Str::startsWith($name, 'webChecks')) {
            $this->rebuildUrlForWebChecks();
        }
    }

    protected function rebuildUrlForWebChecks()
    {
        $this->webChecks = collect($this->webChecks)->map(function ($check) {
            $check['url'] = $this->rebuildUrl($check);

            return $check;
        })->all();
    }

    protected function rebuildUrl(array $check)
    {
        return sprintf('%s://%s%s%s%s%s',
            $check['protocol'],
            $check['host'],
            $check['port'] ? ':'.$check['port'] : '',
            $check['path'] ?? '',
            $check['query'] ? '?'.$check['query'] : '',
            $check['fragment'] ? '#'.$check['fragment'] : ''
        );
    }

    protected function displayWebCheck($display = true)
    {
        $this->includeWebChecks = $display;
    }

    protected function buildCreateWebCheckDataCollection(): WebCheckDataCollection
    {
        return WebCheckDataCollection::make($this->webChecks)
            ->filter(fn($webCheck) => $webCheck['active'])
            ->map(fn($webCheck) => $this->buildWebCheckData($webCheck));
    }

    protected function buildWebCheckData($webCheck): WebCheckData
    {
        return new WebCheckData(
            url: $webCheck['url'],
            protocol: $webCheck['protocol'],
            host: $webCheck['host'],
            port: $webCheck['port'],
            path: $webCheck['path'],
            query: $webCheck['query'],
            fragment: $webCheck['fragment'],
            method: $webCheck['method'],
            expectedHttpStatus: $webCheck['expectedStatus'],
            expectedPattern: $webCheck['expectedPattern'],
            headers: $webCheck['headers'],
            searchHtmlSource: $webCheck['searchSource'],
        );
    }
}
