<?php

declare(strict_types=1);

namespace Diwms\NginxLogAnalyzer\Contracts;

interface Parser
{
    public function usePattern(Pattern $pattern): self;

    public function line(string $line): object;
}
