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
    $squared = Math::square(4);

    $this->assertSame(16, $squared);
  }

  public function test_square_with_staticmock(): void
  {
    $staticmock = StaticMock::mock('Math');

    $staticmock->shouldReceive('multiply')
      ->once()
      ->with(4, 4)
      ->andReturn(16);

    $squared = Math::square(4);

    $staticmock->assert();
    $this->assertSame(16, $squared);

    unset($staticmock);
  }
}
