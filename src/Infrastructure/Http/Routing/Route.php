<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Http\Routing;

use Cgrd\Application\Enums\RequestMethodEnum;
use Cgrd\Application\Http\Routing\RouteInterface;
use Cgrd\Application\Models\PipelineInterface;

class Route implements RouteInterface
{
    public function __construct(
        public readonly RequestMethodEnum $method,
        public readonly string $path,
        public readonly string $controller,
        public readonly ?string $controllerAction = null,
        public readonly ?string $name = null,
        public readonly ?PipelineInterface $pipeline = null
    ) {
    }

    public function getMethod(): RequestMethodEnum
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getControllerAction(): ?string
    {
        return $this->controllerAction;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPipeline(): ?PipelineInterface
    {
        return $this->pipeline;
    }

    public static function get(
        string $path,
        string $controller,
        ?string $controllerAction = null,
        ?string $name = null,
        ?PipelineInterface $pipeline = null
    ): self {
        return new self(
            RequestMethodEnum::GET,
            $path,
            $controller,
            $controllerAction,
            $name,
            $pipeline
        );
    }

    public static function post(
        string $path,
        string $controller,
        ?string $controllerAction = null,
        ?string $name = null,
        ?PipelineInterface $pipeline = null
    ): self {
        return new self(
            RequestMethodEnum::POST,
            $path,
            $controller,
            $controllerAction,
            $name,
            $pipeline
        );
    }

    public static function put(
        string $path,
        string $controller,
        ?string $controllerAction = null,
        ?string $name = null,
        ?PipelineInterface $pipeline = null
    ): self {
        return new self(
            RequestMethodEnum::PUT,
            $path,
            $controller,
            $controllerAction,
            $name,
            $pipeline
        );
    }

    public static function patch(
        string $path,
        string $controller,
        ?string $controllerAction = null,
        ?string $name = null,
        ?PipelineInterface $pipeline = null
    ): self {
        return new self(
            RequestMethodEnum::PATCH,
            $path,
            $controller,
            $controllerAction,
            $name,
            $pipeline
        );
    }

    public static function delete(
        string $path,
        string $controller,
        ?string $controllerAction = null,
        ?string $name = null,
        ?PipelineInterface $pipeline = null
    ): self {
        return new self(
            RequestMethodEnum::DELETE,
            $path,
            $controller,
            $controllerAction,
            $name,
            $pipeline
        );
    }
}
