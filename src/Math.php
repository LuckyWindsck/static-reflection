<?php

declare(strict_types=1);

final readonly class Math
{
  public static function add(int $a, int $b): int {
    return $a + $b;
  }

  public static function multiply(int $a, int $b): int {
    return $a * $b;
  }

  public static function square(int $a): int {
    return Math::multiply($a, $a);
  }
}
