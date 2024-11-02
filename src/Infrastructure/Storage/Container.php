<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Storage;

use Cgrd\Application\Exceptions\DefinitionAlreadySetException;
use Cgrd\Application\Exceptions\DefinitionNotFoundException;
use Cgrd\Application\Storage\ContainerInterface;

class Container implements ContainerInterface
{
    /** @param array<int, \Closure> $services */
    private array $services = [];

    /** @inheritDoc */
    public function get(string $id)
    {
        if (!$this->has($id)) {
            throw DefinitionNotFoundException::createWithServiceName($id);
        }

        return $this->services[$id];
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }

    public function register(string $id, \Closure $definition): self
    {
        if ($this->has($id)) {
            throw DefinitionAlreadySetException::createWithServiceName($id);
        }

        $this->services[$id] = $definition;

        return $this;
    }
}
