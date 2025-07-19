<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class MathTest extends TestCase
{
    public function test_add(): void
    {
        $sum = Math::add(1, 2);

        $this->assertSame(3, $sum);
    }

    public function test_multiply(): void
    {
        $product = Math::multiply(2, 3);

        $this->assertSame(6, $product);
    }

    public function test_square(): void
    {
        $squared = Math::square(4); // Math::multiply is not mocked

        $this->assertSame(16, $squared);
    }

    public function test_square_with_staticmock(): void
    {
        $staticmock = StaticMock::mock('Math'); // Cannot go to definition

        $staticmock->shouldReceive('multiply') // Same here
          ->once()
          ->with(4, 4)
          ->andReturn(16);

        $squared = Math::square(4);

        $staticmock->assert();
        $this->assertSame(16, $squared);

        unset($staticmock);
    }

    public function test_square_with_staticmock_and_first_class_callable(): void
    {
        [
            'class_name' => $class_name,
            'method_name' => $method_name,
        ] = StaticReflection::getClosureName(
            Math::multiply(...) // Can go to definition
        );

        $staticmock = StaticMock::mock($class_name);

        $staticmock->shouldReceive($method_name)
          ->once()
          ->with(4, 4)
          ->andReturn(16);

        $squared = Math::square(4);

        $staticmock->assert();
        $this->assertSame(16, $squared);

        unset($staticmock);
    }
}
