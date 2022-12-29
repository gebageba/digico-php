<?php

namespace Evolu\Digico;

class BaseBuilder
{
    private array $data;

    protected function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return static
     */
    protected function with(string $key, $value): static
    {
        $copy = clone $this;
        $copy->data[$key] = $value;
        return $copy;
    }

    protected function getData(): array
    {
        return $this->data;
    }
}
