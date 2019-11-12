<?php

declare(strict_types=1);

namespace Diwms\NginxLogAnalyzer\Tests;

use Diwms\NginxLogAnalyzer\NginxAccessLogFormat;
use Diwms\NginxLogAnalyzer\Parse;
use Diwms\NginxLogAnalyzer\RegexPattern;
use PHPUnit\Framework\TestCase;
use SplFileObject;
use stdClass;

class ParseTest extends TestCase
{
    /** @var Parse */
    private $parse;

    /** @var SplFileObject */
    private $fixture;

    protected function setUp() : void
    {
        parent::setUp();

        $this->fixture = new SplFileObject(__DIR__ . '/logs/access.log');
        $this->parse   = new Parse(new NginxAccessLogFormat(), new RegexPattern());
    }

    /**
     * @test
     */
    public function canParseSingleLine() : void
    {
        $line   = $this->fixture->fgets();
        $result = $this->parse->line($line);

        $this->assertInstanceOf(stdClass::class, $result);
    }
}
