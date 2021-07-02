<?php

namespace App\Support;

use App\Support\Mail\MarkdownTableBuilder;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class Formatter
{
    private string $cssClass = '';

    private string $tableCaption = '';

    public function __construct(private array $data) { }

    /**
     * Create a single string with all meta data of a monitoring event
     *
     * @param  array  $input
     * @return string
     */
    public static function flattenMeta(array $input): string
    {
        $return = '';
        foreach ($input as $key => $value) {
            $return .= sprintf("%s: %s\n", str_replace('_', ' ', Str::snake($key)), trim($value));
        }

        return $return;
    }

    public static function fromArray(array $input)
    {
        return new self($input);
    }

    public function toBlackBoxHtmlString()
    {
        $consoleLine = "<p class='console__line'><span class='console__title'>%s</span><span class='console__body'>%s</span></p>";

        $lines = collect($this->data)
            ->filter(fn($value) => value($value))
            ->reduce(fn($result, $value, $key) => with($result,
                fn(&$result) => $result .= sprintf($consoleLine, $key, value($value))), ''
            );

        return new HtmlString('<div class="console">'.$lines.'</div>');
    }

    public function addClass(string $class): self
    {
        $this->cssClass = "class='{$class}'";

        return $this;
    }

    public function addCaption(string $caption): self
    {
        $this->tableCaption = "<caption>{$caption}</caption>";

        return $this;
    }

    public function withEmojis(): self
    {
        foreach ($this->data as $key => $value) {
            $value = trim($value);
            // Append some emojis to commonly used keywords
            $this->data[$key] = str_replace(
                ['up', 'down'],
                ['✅ (up)', '❌ (down)'],
                $value
            );
        }

        return $this;
    }

    public function toHtmlString(): HtmlString
    {
        return new HtmlString($this->toHtml());
    }

    /**
     * Create a html table out of an array
     *
     * @return string
     */
    public function toHtml(): string
    {
        $return = "<table {$this->cssClass}>{$this->tableCaption}";
        foreach ($this->data as $key => $value) {
            $return .= sprintf(
                "<tr><td class='row-key'>%s</td><td class='row-value'>%s</td></tr>\n",
                self::camelHumanReadable($key),
                $value);
        }

        return $return.'</table>';
    }

    public static function camelHumanReadable(string $input): string
    {
        $input = explode('_', Str::snake($input));
        foreach ($input as $index => $item) {
            $input[$index] = ucfirst($item);
        }

        return implode(' ', $input);
    }

    public function toMarkdown(): MarkdownTableBuilder
    {
        $builder = resolve(MarkdownTableBuilder::class);

        return match (true) {
            $this->metaHasTableHeader() => $this->buildDataDrivenMarkdownTable($builder),
            default => $this->buildKeyValueMarkdownTable($builder),
        };
    }

    private function metaHasTableHeader(): bool
    {
        return array_key_exists('header', $this->data);
    }

    private function buildDataDrivenMarkdownTable(MarkdownTableBuilder $builder): MarkdownTableBuilder
    {
        $builder
            ->headers(...$this->data['header'])
            ->rows(...$this->data['values']);

        if (array_key_exists('align', $this->data)) {
            $builder->align(...$this->data['align']);
        } else {
            $builder->align(
                ...array_fill(0, count($this->data['header']), MarkdownTableBuilder::LEFT)
            );
        }

        return $builder;
    }

    private function buildKeyValueMarkdownTable(MarkdownTableBuilder $builder): MarkdownTableBuilder
    {
        $builder
            ->withBlankHeaderCount(2)
            ->align(
                MarkdownTableBuilder::LEFT,
                MarkdownTableBuilder::RIGHT,
            );

        foreach ($this->data as $key => $value) {
            $builder->row([
                self::camelHumanReadable($key),
                $value,
            ]);
        }

        return $builder;
    }
}
