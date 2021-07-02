<?php


namespace App\Support\Influx;

/**
 * Class FluxQuery, Creates a line protocol query string
 * @link https://docs.influxdata.com/influxdb/v2.0/query-data/flux/
 * @package App\Support\Influx
 */
class FluxQuery
{
    private ?array $whereTags = null;
    private ?array $whereFields = null;
    private string $rangeStart = '1970-01-01T00:00:00.000000001Z';
    private string $rangeStop = 'now()';
    private string $method = 'last()';
    private ?string $groupBy = null;
    private ?string $measurement = null;

    public function __construct(private string $bucket, ?string $measurement = null)
    {
        $this->measurement = $measurement;
    }

    /**
     * Start building a InfluxDB2 query
     * @param string $bucket
     * @param string $measurement aka the table
     * @return FluxQuery
     */
    public static function build(string $bucket, ?string $measurement = null)
    {
        return new self($bucket, $measurement);
    }

    public function measurement(string $measurement)
    {
        $this->measurement = $measurement;
        return $this;
    }

    public function whereTag(string $tag, string $value)
    {
        $this->whereTags[$tag] = $value;

        return $this;
    }

    public function whereField(array $whereField)
    {
        $this->whereFields[] = $whereField;

        return $this;
    }

    public function groupBy(string $column)
    {
        $this->groupBy = $column;
        return $this;
    }

    public function range(string $rangeStart, string $rangeStop = 'now()')
    {
        // https://docs.influxdata.com/influxdb/v2.0/reference/flux/stdlib/built-in/transformations/range/
        $this->rangeStart = $rangeStart;
        $this->rangeStop = $rangeStop;
        return $this;
    }

    public function toLineProtocol(): string
    {
        $lines[] = sprintf('from(bucket: "%s")', $this->bucket);
        $lines[] = sprintf('|> range(start: %s, stop: %s)', $this->rangeStart, $this->rangeStop);
        $lines[] = sprintf('|> %s', $this->method);
        $lines[] = sprintf(
            '|> filter(fn: (r) => r._measurement == "%s" %s)',
            $this->measurement,
            $this->tagsToFilterString()
        );
        $lines[] = '|> drop(columns:["_start", "_stop", "_measurement"])'; // We don't need these columns
        $lines[] = '|> map(fn:(r) => ({ r with timestampns: uint(v: r._time) }))'; // Always return an additional columns with the time as timestamp
        if (!is_null($this->groupBy)) {
            $lines[] = sprintf('|> group(columns: ["%s"], mode: "by")', $this->groupBy);
        }
        $lines[] = '|> sort(columns:["_time"],desc:true)';
        return implode("\n", $lines);
    }

    private function tagsToFilterString(): string
    {
        if (is_null($this->whereTags)) return '';
        if (count($this->whereTags) === 0) return '';
        $return = 'and ';
        foreach ($this->whereTags as $key => $value) {
            $return .= sprintf('r.%s == "%s"', $key, $value);
        }

        return $return;
    }

    private function fieldsToFilterString(): string
    {
        if (is_null($this->whereFields)) return '';
        if (count($this->whereFields) === 0) return '';
        $return = 'and ';
        foreach ($this->whereFields as $key => $value) {
            $return .= sprintf('r._%s == "%s"', $key, $value);
        }

        return $return;
    }
}
