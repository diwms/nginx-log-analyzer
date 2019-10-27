<?php

declare(strict_types=1);

namespace Diwms\NginxLogAnalyzer\Exceptions;

use InvalidArgumentException;

class InvalidLogFile extends InvalidArgumentException
{
    public static function wrongPath(string $path): self
    {
        return new self("`{$path}` does not exist or not readable");
    }
}
