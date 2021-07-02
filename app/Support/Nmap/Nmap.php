<?php

namespace App\Support\Nmap;

use Illuminate\Support\Facades\Cache;
use RuntimeException;
use Symfony\Component\Process\Process;

class Nmap
{
    public array $ports = [
        21, 22, 25, 80, 110, 143,
        443, 465, 587, 993, 995,
        3306, 3389, 8080, 8443,
    ];

    public int $timeout = 5;

    public function __construct(public ?string $outputFile = null)
    {
        $this->outputFile = $outputFile ?: '%s-nmap-output-'.now()->timestamp.'.xml';
    }

    public static function create(): static
    {
        return new static();
    }

    public function withPorts(int ...$ports): self
    {
        $this->ports = $ports;

        return $this;
    }

    public function scan(string $target): ?Host
    {
        $ttl = now()->addMinutes(5);

        return Cache::remember(md5("nmap-scan-{$target}"), $ttl, function () use ($target) {
            $this->outputFile = storage_path('nmapOutput/'.sprintf($this->outputFile, md5($target)));

            $this->execute($this->buildCommand($target));

            if (! file_exists($this->outputFile)) {
                throw new RuntimeException(sprintf('Output file not found ("%s")', $this->outputFile));
            }

            $output = NmapXmlParser::parseOutputFile($this->outputFile);

            unlink($this->outputFile);

            return $output;
        });
    }

    private function execute(array $command): int
    {
        $process = new Process($command, null, null, null, $this->timeout);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new RuntimeException(sprintf(
                'Failed to execute "%s"'.PHP_EOL.'%s',
                implode(' ', $command),
                $process->getErrorOutput()
            ));
        }

        return (int) $process->getExitCode();
    }

    private function buildCommand(string $target): array
    {
        if (substr_count($target, ':') > 1) {
            $options[] = '-6';
        } else {
            $options[] = '-4';
        }

        $options[] = '-p '.implode(',', $this->ports);
        $options[] = '-n';
        $options[] = '-oX';
        $options[] = $this->outputFile;

        return array_merge(['nmap'], [$target], $options);
    }

    public function setTimeout($timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }
}
