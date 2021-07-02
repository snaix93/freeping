<?php

namespace App\Support\Mail;

use Illuminate\Contracts\Support\Renderable;

class MarkdownTableBuilder implements Renderable
{
    const LEFT   = 'L';
    const CENTER = 'C';
    const RIGHT  = 'R';

    protected $headers = [];

    protected $alignments = [];

    protected $rows = [];

    public function withBlankHeaderCount($count)
    {
        $this->headers(...array_fill(0, $count, ' '));

        return $this;
    }

    public function headers(...$headers)
    {
        $this->headers = $headers;

        return $this;
    }

    public function align(...$alignments)
    {
        $this->alignments = $alignments;

        return $this;
    }

    public function rows(...$rows)
    {
        foreach ($rows as $row) {
            $this->row($row);
        }

        return $this;
    }

    public function row($row)
    {
        $this->rows[] = $row;

        return $this;
    }

    public function render()
    {
        $widths = $this->calculateWidths();

        $table = $this->renderHeaders($widths);
        $table .= $this->renderRows($widths);

        return $table;
    }

    protected function calculateWidths()
    {
        $widths = [];

        foreach (array_merge([$this->headers], $this->rows) as $row) {
            for ($i = 0; $i < count($row); $i++) {
                $iWidth = strlen((string) $row[$i]);
                if ((! array_key_exists($i, $widths)) || $iWidth > $widths[$i]) {
                    $widths[$i] = $iWidth;
                }
            }
        }

        // all columns must be at least 3 wide for the markdown to work
        return array_map(fn($width) => $width >= 3 ? $width : 3, $widths);
    }

    protected function renderHeaders($widths): string
    {
        $result = '| ';
        for ($i = 0; $i < count($this->headers); $i++) {
            $result .= $this->renderCell($this->headers[$i], $this->columnAlign($i), $widths[$i]).' | ';
        }

        return rtrim($result, ' ').PHP_EOL.$this->renderAlignments($widths).PHP_EOL;
    }

    protected function renderCell($contents, $alignment, $width): string
    {
        $alignmentLookup = [
            self::LEFT   => STR_PAD_RIGHT,
            self::CENTER => STR_PAD_BOTH,
            self::RIGHT  => STR_PAD_LEFT,
        ];

        return str_pad($contents, $width, ' ', $alignmentLookup[$alignment]);
    }

    protected function columnAlign($columnNumber): string
    {
        if (collect([self::LEFT, self::CENTER, self::RIGHT])->contains($this->alignments[$columnNumber])) {
            return $this->alignments[$columnNumber];
        }

        return self::LEFT;
    }

    protected function renderAlignments($widths)
    {
        $row = '|';
        for ($i = 0; $i < count($widths); $i++) {
            $cell = str_repeat('-', $widths[$i] + 2);
            $align = $this->columnAlign($i);

            if ($align === self::LEFT) {
                $cell = ':'.substr($cell, 1);
            }

            if ($align === self::CENTER) {
                $cell = ':'.substr($cell, 2).':';
            }

            if ($align === self::RIGHT) {
                $cell = substr($cell, 1).':';
            }

            $row .= $cell.'|';
        }

        return $row;
    }

    protected function renderRows($widths)
    {
        $result = '';
        foreach ($this->rows as $row) {
            $result .= '| ';
            for ($i = 0; $i < count($row); $i++) {
                $result .= $this->renderCell($row[$i], $this->columnAlign($i), $widths[$i]).' | ';
            }
            $result = rtrim($result, ' ').PHP_EOL;
        }

        return $result;
    }
}
