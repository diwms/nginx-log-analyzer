<?php

declare(strict_types=1);

namespace Diwms\NginxLogAnalyzer;

use Diwms\NginxLogAnalyzer\Exceptions\InvalidLogFile;
use SplFileObject;

class Log
{
    protected $file;

    public function __construct(string $path)
    {
        if (!file_exists($path) || !is_readable($path)) {
            throw InvalidLogFile::wrongPath($path);
        }

        $this->file = new SplFileObject($path);
    }
}
