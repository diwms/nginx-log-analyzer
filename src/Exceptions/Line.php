<?php

declare(strict_types=1);

namespace Diwms\NginxLogAnalyzer\Exceptions;

use UnexpectedValueException;
use function sprintf;

class Line extends UnexpectedValueException
{
    public static function doesNotMatchRegex(string $line, string $regex) : self
    {
        return new self(sprintf('Line `%s` does not match `%s`', $line, $regex));
    }

    public static function isEmpty() : self
    {
        return new self('Empty line is not allowed');
    }
}
