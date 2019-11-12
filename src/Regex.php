<?php

declare(strict_types=1);

namespace Diwms\NginxLogAnalyzer;

use Diwms\NginxLogAnalyzer\Contracts\{Pattern, Format};

final class Regex implements Pattern
{
    private const CAPTURE_VALUE = '/^(\w*)(.*?)$/';

    private $identifiers;

    private $format;

    public function __construct(Format $format)
    {
        $this->format = $format;
    }

    public function build(): string
    {
        $this->identifiers = [];

        $pieces = explode('$', $this->format->getStringRepresentation());
        $delimiters = [];

        array_push($delimiters, array_shift($pieces));

        foreach ($pieces as $piece) {
            preg_match(self::CAPTURE_VALUE, $piece, $token);

            $this->identifiers[] = $token[1];
            $delimiters[] = preg_quote($token[2]);
        }

        return sprintf('/^%s$/', implode('(.+?)', $delimiters));
    }

    public function validate(): bool
    {
        return preg_match($this->build(), null) === false;
    }

    public function getIdentifiers(): array
    {
        return $this->identifiers;
    }

    public function getFormat(): Format
    {
        return $this->format;
    }
}
