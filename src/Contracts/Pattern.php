<?php

declare(strict_types=1);

namespace Diwms\NginxLogAnalyzer\Contracts;

interface Pattern
{
    public function build(Format $format) : string;

    /**
     * @return array<string>
     */
    public function getIdentifiers() : array;
}
