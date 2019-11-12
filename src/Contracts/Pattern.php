<?php

declare(strict_types=1);

namespace Diwms\NginxLogAnalyzer\Contracts;

interface Pattern
{
    public function build(): string;

    public function validate(): bool;

    public function getIdentifiers(): array;

    public function getFormat(): Format;
}
