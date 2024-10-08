<?php

declare(strict_types=1);

namespace RoadieXX;

use InvalidArgumentException;
use RuntimeException;

class DotEnv
{
    /**
     * The directory where the .env file can be located.
     */
    protected string $path;


    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new InvalidArgumentException(sprintf('File "%s" does not exist', $path));
        }

        $this->path = $path;
    }

    public function load(): void
    {
        if (!is_readable($this->path)) {
            throw new RuntimeException(sprintf('File "%s" is not readable', $this->path));
        }

        $lines = file($this->path);

        if ($lines === false) {
            throw new RuntimeException(sprintf('Could not parse file "%s"', $this->path));
        }

        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            [$name, $value] = explode('=', $line, 2);

            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}
