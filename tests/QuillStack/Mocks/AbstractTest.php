<?php

declare(strict_types=1);

namespace QuillStack\Mocks;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriFactoryInterface;
use QuillStack\DI\Container;
use QuillStack\Http\Request\Factory\ServerRequest\GivenRequestFromGlobalsFactory;
use QuillStack\Http\Request\Factory\ServerRequest\RequestFromGlobalsFactory;
use QuillStack\Http\Stream\InputStream;
use QuillStack\Http\Uri\Factory\UriFactory;
use QuillStack\Router\Dispatcher;
use QuillStack\Router\Route;
use QuillStack\Router\Router;

abstract class AbstractTest extends TestCase
{
    public const SERVER = [];
    public const REQUEST = '';

    /**
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface
    {
        $container = new Container([
            StreamInterface::class => InputStream::class,
            UriFactoryInterface::class => UriFactory::class,
            RequestFromGlobalsFactory::class => [
                'server' => static::SERVER,
            ],
        ]);

        $factory = $container->get(GivenRequestFromGlobalsFactory::class);

        return $factory->createGivenServerRequest(static::REQUEST);
    }

    /**
     * @param Router $router
     *
     * @return Route|null
     */
    public function getRoute(Router $router): ?Route
    {
        $dispatcher = new Dispatcher($router);

        return $dispatcher->dispatch(
            $this->getRequest()
        );
    }
}
