<?php

namespace Cgrd\Infrastructure\Factories;

use Cgrd\Application\Models\ServiceDefinitionInterface;
use Cgrd\Application\Storage\ContainerInterface;
use Cgrd\Infrastructure\Storage\InMemoryContainer;

class InMemoryContainerFactory
{
    public static function create(): ContainerInterface
    {
        $configPath = sprintf('%s/di/services.php', CONFIG_BASE_PATH);
        $container = new InMemoryContainer();

        /** @var ServiceDefinitionInterface $serviceDefinition */
        foreach (require_once $configPath as $serviceDefinition) {
            $container->register(
                $serviceDefinition->getName(),
                $serviceDefinition->getDefinition()
            );
        }

        return $container;
    }
}