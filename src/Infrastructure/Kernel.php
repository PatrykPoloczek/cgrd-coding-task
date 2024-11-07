<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure;

use Cgrd\Application\Exceptions\HttpException;
use Cgrd\Application\Exceptions\ValidationException;
use Cgrd\Application\Http\RequestInterface;
use Cgrd\Application\Http\ResponseInterface;
use Cgrd\Application\Http\Routing\RouterInterface;
use Cgrd\Application\KernelInterface;
use Cgrd\Application\Logger\LoggerInterface;
use Cgrd\Application\Storage\ContainerInterface;
use Cgrd\Infrastructure\Factories\InMemoryContainerFactory;
use Cgrd\Infrastructure\Factories\RequestFactory;
use Cgrd\Infrastructure\Handlers\PipelineHandler;

class Kernel implements KernelInterface
{
    private const SUCCESS = 0;
    private const FAILURE = 1;

    private RequestFactory $requestFactory;

    private ContainerInterface $container;
    private LoggerInterface $logger;

    public function __construct()
    {
    }

    public function bootstrap(): void
    {
        $this->container = InMemoryContainerFactory::create();
        $this->requestFactory = $this->container->get(RequestFactory::class);
        $this->logger = $this->container->get(LoggerInterface::class);
    }

    public function run(): int
    {
        try {
            $this->bootstrap();

            $this->handleRequest($this->requestFactory->createFromGlobals());

            return self::SUCCESS;
        } catch (ValidationException $exception) {
            $this->logger->error(
                'Validation exception encountered.',
                [
                    'message' => $exception->getMessage(),
                    'errors' => $exception->getErrors(),
                    'trace' => $exception->getTraceAsString(),
                ]
            );
            $this->sendValidationException($exception);

            return self::FAILURE;
        } catch (HttpException $exception) {
            $this->logger->error(
                'Http exception encountered.',
                [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
                ]
            );
            $this->sendException($exception);

            return self::FAILURE;
        } catch (\Throwable $exception) {
            $this->logger->error(
                'Exception encountered.',
                [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
                ]
            );

            return (int) $exception->getCode() === self::SUCCESS
                ? self::FAILURE
                : (int) $exception->getCode()
            ;
        }
    }

    private function handleRequest(RequestInterface $request): void
    {
        /** @var RouterInterface $router */
        $router = $this->container->get(RouterInterface::class);
        $router->register();
        $route = $router->resolve($request);
        /** @var PipelineHandler $pipelineHandler */
        $pipelineHandler = $this->container->get(PipelineHandler::class);
        $request = $pipelineHandler->handle($request, $this->container, $route->getPipeline());

        $controller = $this->container->get($route->getController());
        $action = $route->getControllerAction();

        /** @var ResponseInterface $response */
        $response = empty($action)
            ? $controller($request)
            : $controller->$action($request)
        ;
        dd ($response);

        $this->sendResponse($response);
    }

    private function sendResponse(ResponseInterface $response): void
    {
        $this->sendServerResponse(
            $response->getStatusCode()->value,
            $response->getBody()
        );
    }

    private function sendException(HttpException $exception): void
    {
        $this->sendServerResponse(
            $exception->getCode(),
            json_encode([
                'message' => $exception->getMessage(),
            ])
        );
    }

    private function sendValidationException(ValidationException $exception): void
    {
        $this->sendServerResponse(
            $exception->getCode(),
            json_encode([
                'message' => $exception->getMessage(),
                'errors' => $exception->getErrors(),
            ])
        );
    }

    private function sendServerResponse(int $code, string $body): void
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($code);
        echo $body;
    }
}
