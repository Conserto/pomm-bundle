<?php

namespace PommProject\PommBundle\ValueResolver\Attribute;

#[\Attribute(\Attribute::TARGET_PARAMETER)]
class Entity
{
    public function __construct(
        private readonly ?string $sessionName = null,
        private readonly ?string $modelClass = null
    ) {
    }

    public function getSessionName(): string
    {
        return $this->sessionName;
    }

    public function getModelClass(): string
    {
        return $this->modelClass;
    }
}
