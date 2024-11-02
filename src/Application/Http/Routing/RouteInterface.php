<?php

declare(strict_types=1);

namespace Cgrd\Application\Http\Routing;

use Cgrd\Application\Enums\RequestMethodEnum;
use Cgrd\Application\Models\PipelineInterface;

interface RouteInterface
{
    public function getMethod(): RequestMethodEnum;
    public function getPath(): string;
    public function getController(): string;
    public function getControllerAction(): ?string;
    public function getName(): ?string;
    public function getPipeline(): ?PipelineInterface;
    public static function get(
        string $path,
        string $controller,
        ?string $controllerAction = null,
        ?string $name = null,
        ?PipelineInterface $pipeline = null
    ): self;
    public static function post(
        string $path,
        string $controller,
        ?string $controllerAction = null,
        ?string $name = null,
        ?PipelineInterface $pipeline = null
    ): self;
    public static function put(
        string $path,
        string $controller,
        ?string $controllerAction = null,
        ?string $name = null,
        ?PipelineInterface $pipeline = null
    ): self;
    public static function patch(
        string $path,
        string $controller,
        ?string $controllerAction = null,
        ?string $name = null,
        ?PipelineInterface $pipeline = null
    ): self;
    public static function delete(
        string $path,
        string $controller,
        ?string $controllerAction = null,
        ?string $name = null,
        ?PipelineInterface $pipeline = null
    ): self;
}
