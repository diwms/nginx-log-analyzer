<?php

declare(strict_types=1);

namespace Diwms\NginxLogAnalyzer\Contracts;

interface Parsable
{
    public function line(string $line) : object;
}
