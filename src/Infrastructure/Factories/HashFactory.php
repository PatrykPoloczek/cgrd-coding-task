<?php

declare(strict_types=1);

namespace Cgrd\Infrastructure\Factories;

use Cgrd\Application\Http\RequestInterface;
use Cgrd\Application\Http\Routing\RouteInterface;
use Cgrd\Application\Models\UserInterface;

class HashFactory
{
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    public static function createFromRoute(RouteInterface $route): string
    {
        return static::create($route->getMethod()->value, $route->getPath());
    }

    public static function createFromRequest(RequestInterface $request): string
    {
        return static::create($request->getMethod()->value, $request->getPath());
    }

    public static function createFromPassword(string $password): string
    {
        return password_hash(
            $password,
            PASSWORD_BCRYPT,
            [
                'cost' => 12,
            ]
        );
    }

    private static function create(string $method, string $path): string
    {
        return sha1(
            sprintf(
                '%s-%s',
                strtoupper($method),
                $path
            )
        );
    }

    public static function createFromUserAndTimestamp(
        UserInterface $user,
        ?\DateTime $timestamp = null
    ): string {
        return hash(
            'sha256',
            sprintf(
                '%s-%s-%s',
                $user->getId(),
                $user->getLogin(),
                ($timestamp ?? new \DateTime())->format(self::DATE_FORMAT)
            )
        );
    }

    public static function createFromUserIdTitleAndTimestamp(
        int $userId,
        string $title,
        ?\DateTime $timestamp = null
    ): string {
        return hash(
            'sha256',
            sprintf(
                '%d-%s-%s',
                $userId,
                $title,
                ($timestamp ?? new \DateTime())->format(self::DATE_FORMAT)
            )
        );
    }
}
