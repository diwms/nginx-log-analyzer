<?php

declare(strict_types=1);

namespace Diwms\NginxLogAnalyzer\Exceptions;

use UnexpectedValueException;

class StringDoesNotMatch extends UnexpectedValueException
{
    public static function regex(string $line, string $regex): self
    {
        return new self("Line `{$line}` does not match `{$regex}`");
    }
}
