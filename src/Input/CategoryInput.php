<?php

namespace App\Input;

use App\Component\Input\AbstractInput;

class CategoryInput extends AbstractInput
{
    private const DEFAULT_NAME = '';
    private const DEFAULT_SLUG = '';
    private const DEFAULT_ENABLED = false;

    public function getName(): string
    {
        return $this->getParameter('name', self::DEFAULT_NAME);
    }

    public function getSlug(): string
    {
        return $this->getParameter('slug', self::DEFAULT_SLUG);
    }

    public function getEnabled(): bool
    {
        return $this->getParameter('enabled', self::DEFAULT_ENABLED);
    } 
}
