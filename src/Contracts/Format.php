<?php

declare(strict_types=1);

namespace Diwms\NginxLogAnalyzer\Contracts;

interface Format
{
    public function getStringRepresentation(): string;
}
