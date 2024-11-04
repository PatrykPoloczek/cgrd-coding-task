<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Storage;

use Cgrd\Application\Exceptions\DefinitionAlreadySetException;
use Cgrd\Application\Exceptions\DefinitionNotFoundException;
use Cgrd\Application\Storage\ContainerInterface;

class InMemoryContainer implements ContainerInterface
{
    /** @param array<int, \Closure> $services */
    private array $services = [];

    /** @inheritDoc */
    public function get(string $id)
    {
        if (!$this->has($id)) {
            throw DefinitionNotFoundException::createWithServiceName($id);
        }

        /** @var \Closure $service */
        $service = $this->services[$id];
        $reflectionFunction = new \ReflectionFunction($service);
        $parameters = [];

        if ($reflectionFunction->getNumberOfParameters() === 0) {
            return $this->services[$id]();
        }

        foreach ($reflectionFunction->getParameters() as $parameter) {
            if ($this->has($parameter->getType()->getName())) {
                $parameters[] = $this->get($parameter->getType()->getName());

                continue;
            }

            $parameters[] = $this->get($parameter->getName());
        }

        return $service(...$parameters);
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

    public function getService(): array
    {
        return $this->services;
    }
}
