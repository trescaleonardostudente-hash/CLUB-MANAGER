<?php declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;
use ClubManager\Greeter;

require_once __DIR__ . '/../src/Greeter.php';

final class GreeterTest extends TestCase
{
    // Testa che il metodo greet restituisca un saluto corretto con il nome fornito
    public function testGreetsWithName(): void
    {
        $greeter = new Greeter;

        $greeting = $greeter->greet('Alice');

        $this->assertSame('Hello, Alice!', $greeting);
    }
}