<?php

namespace App\Support\Influx;

use App\Exceptions\InfluxEmptyResultException;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class FluxResults
{
    public function __construct(private ?array $results) { }

    /**
     * Parse the results of an InfluxDB query aka process the list of FluxTable Objects and convert them to an array.
     *
     * @param  array|null  $input  Array of FluxTable Objects.
     * @return static
     */
    public static function fromQuery(?array $input): self
    {
        if (is_null($input)) {
            return new self(null);
        }
        $results = null;
        foreach ($input as $fluxRecord) {
            // Influx results are not structured with rows and columns.
            // A table with 3 columns and 2 rows will return 6 objects.
            // The timestamp (ns) is the only option to group objects that belong to the same row.
            $index = $fluxRecord->values['timestampns'];
            $key = $fluxRecord->values['_field'];
            $value = $fluxRecord->values['_value'];
            $time = $fluxRecord->values['_time'];
            $results[$index]['time_string'] = $time;
            $results[$index]['time'] = new Carbon(substr($time, 0, -3).'Z');
            if (preg_match("/^[\{,\[].*[\},\]]$/", $value)) {
                // Auto-decode json values
                try {
                    $results[$index][$key.'_raw'] = $value;
                    $results[$index][$key] = json_decode($value, true, 1024, JSON_THROW_ON_ERROR);
                } catch (Exception $exception) {
                    $results[$index][$key] = $value;
                }
            } elseif (str_ends_with($key, '_at',) && preg_match("/[0-9]{4}\-[0-9]{2}\-[0-9]{2}T.*Z$/", $value)) {
                // Auto-decode time values
                $results[$index][$key.'_string'] = $value;
                $results[$index][$key] = new Carbon(substr($value, 0, -3).'Z');
            } else {
                $results[$index][$key] = $value;
            }
            // Extract the tags and tag values
            foreach ($fluxRecord->values as $tagKey => $tagValue) {
                if (str_starts_with($tagKey, '_')) {
                    continue;
                } // Tags are not prefixed with underscores.
                if (in_array($tagKey, ['result', 'table'])) {
                    continue;
                } // Reserved tags
                $results[$index][$tagKey] = $tagValue;
            }
        }

        return new self($results);
    }

    /**
     * Return all records as multidimensional array
     *
     * @return array|null
     */
    public function all(): ?array
    {
        return $this->results;
    }

    /**
     * Return all records as a Collection
     *
     * @return Collection
     */
    public function collect(): Collection
    {
        return collect($this->results);
    }

    public function firstOrFail(string|array|null $filterColumns = null): mixed
    {
        throw_if(! $this->results, new InfluxEmptyResultException());

        return $this->first($filterColumns);
    }

    /**
     * Return the first record. Optionally return only filtered columns.
     *
     * @param  string|array|null  $filterColumns
     * @return mixed
     */
    public function first(string|array|null $filterColumns = null): mixed
    {
        if (is_null($this->results)) {
            return null;
        }

        return $this->filterColumns($this->results[0], $filterColumns);
    }

    private function filterColumns(?array $input, string|array|null $columns): mixed
    {
        if (is_null($input)) {
            return null;
        }
        $return = null;
        if (is_array($columns)) {
            foreach ($input as $key => $value) {
                if (in_array($key, $columns)) {
                    $return[$key] = $value;
                }
            }

            return $return;
        } elseif (is_string($columns)) {
            if (array_key_exists($columns, $input)) {
                return $input[$columns];
            }
        }

        return null;
    }
}
