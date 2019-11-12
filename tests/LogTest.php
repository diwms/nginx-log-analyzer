<?php

declare(strict_types=1);

namespace Diwms\NginxLogAnalyzer\Tests;

use Diwms\NginxLogAnalyzer\Exceptions\InvalidLogFile;
use Diwms\NginxLogAnalyzer\Log;
use Diwms\NginxLogAnalyzer\NginxAccessLog;
use Diwms\NginxLogAnalyzer\Regex;
use PHPUnit\Framework\TestCase;
use Ramsey\Collection\Collection;
use SplFileObject;
use stdClass;

class LogTest extends TestCase
{
    protected $parser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->parser = (new Log(__DIR__ . '/logs/access.log'))
            ->usePattern(new Regex(new NginxAccessLog()));
    }

    /**
     * @test
     */
    public function log_throw_exception_when_file_is_invalid(): void
    {
        $this->expectException(InvalidLogFile::class);

        new Log('blah-blah');
    }

    /**
     * @test
     */
    public function log_can_parse_line(): void
    {
        /** @var SplFileObject $file */
        $file = $this->parser->getFile();
        $line = $file->fgets();

        $result = $this->parser->line($line);

        $this->assertInstanceOf(stdClass::class, $result);
    }

    /**
     * @test
     */
    public function log_can_return_collection(): void
    {
        $result = $this->parser->collection();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(7, $result);
    }
}
