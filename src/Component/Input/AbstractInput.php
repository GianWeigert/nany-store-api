<?php

namespace App\Component\Input;

abstract class AbstractInput
{
    protected $parameters;

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    protected function getParameter(string $keyParam, $default = null)
    {
        return $this->parameters[$keyParam] ?? $default;
    }
}