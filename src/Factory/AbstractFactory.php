<?php

declare(strict_types=1);

namespace App\Factory;

abstract class AbstractFactory
{
    abstract protected function data(array $data): array;
    public static function view(array $data): array
    {
        $instance = new static();
        return array_merge(
            $instance->data($data),
            $_ENV['DEBUG_MODE'] ? ['raw_data' => $data] : []
        );
    }
}