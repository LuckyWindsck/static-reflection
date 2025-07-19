<?php

declare(strict_types=1);

final readonly class StaticReflection
{
    /**
     * @return array{
     *   class_name: string,
     *   method_name: string,
     * }
     */
    public static function getClosureName(Closure $closure): array
    {
        $reflection_function = new ReflectionFunction($closure);

        $reflection_class = $reflection_function->getClosureScopeClass();
        if ($reflection_class === null) {
            throw new Exception('reflection_class does not exist');
        }

        $reflection_method = $reflection_class->getMethod($reflection_function->getName());
        if (!$reflection_method->isStatic()) {
            throw new Exception('reflection_method is not static');
        }

        return [
            'class_name' => $reflection_class->getName(),
            'method_name' => $reflection_method->getName(),
        ];
    }
}
