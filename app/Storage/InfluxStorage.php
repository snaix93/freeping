<?php


namespace App\Storage;


use App\Exceptions\InfluxFieldTypeConflictException;
use App\Support\Influx\FluxQuery;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use InfluxDB2\ApiException;
use InfluxDB2\Client;
use InfluxDB2\Model\WritePrecision;
use InfluxDB2\Point;
use InfluxDB2\QueryApi;
use InfluxDB2\WriteApi;

abstract class InfluxStorage
{
    protected Client $client;

    protected ?WriteApi $writeApi = null;

    protected ?QueryApi $queryApi = null;

    public function __construct(protected string $bucket)
    {
        $this->client = new Client([
            'url'       => config('services.influx.url'),
            'token'     => config('services.influx.token'),
            'bucket'    => $bucket,
            'org'       => config('services.influx.org'),
            'precision' => WritePrecision::NS,
        ]);
    }

    protected function read(string|FluxQuery $query)
    {
        if (is_null($this->queryApi)) {
            $this->queryApi = $this->client->createQueryApi();
        }
        if (!is_string($query)) {
            $query = $query->toLineProtocol();
        }
        Log::debug($query);
        $parser = $this->queryApi->queryStream($query);
        $results = null;
        foreach ($parser->each() as $record) {
            $results[] = $record;
        }

        return $results;
    }

    /**
     * @param array|string|Point $data
     * @throws InfluxFieldTypeConflictException
     */
    protected function write(array|string|Point $data): void
    {
        if (is_null($this->writeApi)) {
            $this->writeApi = $this->client->createWriteApi();
        }
        try {
            $this->writeApi->write($data);
        } catch (ApiException $exception) {
            $error = json_decode($exception->getResponseBody(), true);
            $message = Arr::get($error, 'message', 'Unknown ApiException Error');
            if (strpos($message, 'field type conflict:')) {
                throw new InfluxFieldTypeConflictException($message);
            } else {
                Log::Error('Influx Write Error', [$error, $exception->getMessage()]);
            }
        }
    }
}
