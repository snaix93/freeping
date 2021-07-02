<?php

namespace App\Collections;

use App\Models\Port;
use App\Support\Mail\MarkdownTableBuilder;
use Illuminate\Support\Collection;

class ReportablePortsCollection extends Collection
{
    public function addPort(Port $port)
    {
        $this->push($port);
    }

    public function renderResultsAsMarkupTable(): MarkdownTableBuilder
    {
        return $this->reduce(
            fn($tableMarkup, Port $port) => $port->scanResults->formatResultsAsMarkdownTable(
                $port, $tableMarkup
            )
        );
    }
}
