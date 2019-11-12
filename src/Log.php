<?php

declare(strict_types=1);

namespace Diwms\NginxLogAnalyzer;

use Diwms\NginxLogAnalyzer\Exceptions\StringDoesNotMatch;
use Diwms\NginxLogAnalyzer\Contracts\{Format, Parser, Pattern};
use Diwms\NginxLogAnalyzer\Exceptions\InvalidLogFile;
use Ramsey\Collection\Collection;
use SplFileObject;
use stdClass;

final class Log implements Parser
{
    /** @var SplFileObject */
    private $file;

    /** @var Format */
    private $format;

    /** @var Pattern */
    private $pattern;

    public function __construct(string $path)
    {
        if (!file_exists($path) || !is_readable($path)) {
            throw InvalidLogFile::wrongPath($path);
        }

        $this->file = new SplFileObject($path);
    }

    public function collection(): Collection
    {
        $collection = new Collection(stdClass::class);

        while (!$this->getFile()->eof()) {
            $line = $this->getFile()->fgets();

            if ($line !== '') {
                $collection->add(
                    $this->line($line)
                );
            }
        }

        return $collection;
    }

    public function line(string $line): object
    {
        preg_match($this->pattern->build(), $line, $values);
        array_shift($values);

        $identifiers = $this->pattern->getIdentifiers();

        if (count($identifiers) !== count($values)) {
            throw StringDoesNotMatch::regex($line, $this->pattern->build());
        }

        return (object)array_combine($identifiers, $values);
    }

    public function usePattern(Pattern $pattern): Parser
    {
        $this->pattern = $pattern;
        $this->format = $pattern->getFormat();

        return $this;
    }

    public function getFile(): SplFileObject
    {
        return $this->file;
    }
}
