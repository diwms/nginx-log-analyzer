<?php

declare(strict_types=1);

namespace Diwms\NginxLogAnalyzer;

use Diwms\NginxLogAnalyzer\Contracts\Format;
use Diwms\NginxLogAnalyzer\Contracts\Pattern;
use function array_push;
use function array_shift;
use function explode;
use function implode;
use function preg_match;
use function preg_quote;
use function sprintf;

final class RegexPattern implements Pattern
{
    private const CAPTURE_VALUE = '/^(\w*)(.*?)$/';

    /** @var array<string> */
    protected $identifiers = [];

    public function build(Format $format) : string
    {
        $this->identifiers = [];

        $pieces     = explode('$', $format->getStringRepresentation());
        $delimiters = [];

        array_push($delimiters, array_shift($pieces));

        foreach ($pieces as $piece) {
            preg_match(self::CAPTURE_VALUE, $piece, $token);

            $this->identifiers[] = $token[1];
            $delimiters[]        = preg_quote($token[2]);
        }

        return sprintf('/^%s$/', implode('(.+?)', $delimiters));
    }

    /**
     * @return array<string>
     */
    public function getIdentifiers() : array
    {
        return $this->identifiers;
    }
}
