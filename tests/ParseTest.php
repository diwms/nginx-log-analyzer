<?php

declare(strict_types=1);

namespace Diwms\NginxLogAnalyzer\Tests;

use Diwms\NginxLogAnalyzer\Contracts\Format;
use Diwms\NginxLogAnalyzer\Exceptions\Line;
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

    /**
     * @test
     */
    public function throwWhenParseEmptyLine() : void
    {
        $this->expectException(Line::class);

        $this->parse->line('');
    }

    /**
     * @test
     */
    public function throwWhenLineDoesNotMatchRegex() : void
    {
        $this->expectException(Line::class);

        $parse = new Parse(new class implements Format
        {
            public function getStringRepresentation() : string
            {
                return '$this $is $not $valid';
            }
        }, new RegexPattern());

        $parse->line('- -');
    }
}
