<?php

namespace RoadieXX {
    function is_readable($filename) {
        if (\strpos($filename, 'unreadable') !== false) {
            echo 'Hoi';
            return false;
        }

        return \is_readable($filename);
    }
}

namespace Test\RoadieXX { 

    use InvalidArgumentException;
    use RuntimeException;
    use RoadieXX\DotEnv;
    use PHPUnit\Framework\TestCase;
    
    /**
     * @coversDefaultClass \RoadieXX\DotEnv
     */
    class DotEnvTest extends TestCase
    {
        private function loadEnv(string $file)
        {
            return __DIR__ . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . $file;
        }

        /**
         * @runInSeparateProcess
         */
        public function testLoad() {

            (new DotEnv($this->loadEnv('.env.default')))->load();

            $this->assertEquals('dev', getenv('APP_ENV'));
            $this->assertEquals('mysql:host=localhost;dbname=test;', getenv('DATABASE_DNS'));
            $this->assertEquals('root', getenv('DATABASE_USER'));
            $this->assertEquals('password', getenv('DATABASE_PASSWORD'));
            $this->assertFalse(getenv('GOOGLE_API'));
            $this->assertFalse(getenv('GOOGLE_MANAGER_KEY'));
            $this->assertEquals(true, getenv('BOOLEAN_LITERAL'));
            $this->assertEquals('"true"', getenv('BOOLEAN_QUOTED'));

            $this->assertEquals('dev', $_ENV['APP_ENV']);
            $this->assertEquals('password', $_ENV['DATABASE_PASSWORD']);
            $this->assertArrayNotHasKey('GOOGLE_API', $_ENV);
            $this->assertArrayNotHasKey('GOOGLE_MANAGER_KEY', $_ENV);
            $this->assertEquals(true, $_ENV['BOOLEAN_LITERAL']);
            $this->assertEquals('"true"', $_ENV['BOOLEAN_QUOTED']);

            $this->assertEquals('mysql:host=localhost;dbname=test;', $_SERVER['DATABASE_DNS']);
            $this->assertEquals('root', $_SERVER['DATABASE_USER']);
            $this->assertEquals('password', $_SERVER['DATABASE_PASSWORD']);
            $this->assertArrayNotHasKey('GOOGLE_API', $_SERVER);
            $this->assertArrayNotHasKey('GOOGLE_MANAGER_KEY', $_SERVER);
            $this->assertEquals(true, $_SERVER['BOOLEAN_LITERAL']);
            $this->assertEquals('"true"', $_SERVER['BOOLEAN_QUOTED']);

            $this->assertEquals('🪄', $_SERVER['EMOJI']);

            // $this->assertIsInt($_SERVER['ZERO_LITERAL']);
            $this->assertEquals(0, $_SERVER['ZERO_LITERAL']);

            $this->assertIsString($_SERVER['ZERO_QUOTED']);
            $this->assertEquals('"0"', $_SERVER['ZERO_QUOTED']);

            // $this->assertIsInt($_SERVER['NUMBER_LITERAL']);
            $this->assertEquals(1111, $_SERVER['NUMBER_LITERAL']);

            $this->assertIsString($_SERVER['NUMBER_QUOTED']);
            $this->assertEquals('"1111"', $_SERVER['NUMBER_QUOTED']);

            // $this->assertNull($_SERVER['NULL_LITERAL']);
            $this->assertArrayHasKey('NULL_LITERAL', $_SERVER);

            $this->assertEquals('"null"', $_SERVER['NULL_QUOTED']);

            $this->assertEquals('', $_SERVER['EMPTY_LITERAL']);
            $this->assertEquals('""', $_SERVER['EMPTY_QUOTED']);
        }

        public function testFileNotExist() {
            $this->expectException(InvalidArgumentException::class);
            (new DotEnv($this->loadEnv('.env.not-exists')))->load();
        }

        public function testFileNotReadable() {
            $this->expectException(RuntimeException::class);
            (new DotEnv($this->loadEnv('.env.unreadable')))->load();
        }
    }
}
