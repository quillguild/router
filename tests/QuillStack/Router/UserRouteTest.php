<?php

declare(strict_types=1);

namespace QuillStack\Router;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriFactoryInterface;
use QuillStack\DI\Container;
use QuillStack\Http\Request\Factory\ServerRequest\GivenRequestFromGlobalsFactory;
use QuillStack\Http\Request\Factory\ServerRequest\RequestFromGlobalsFactory;
use QuillStack\Http\Stream\InputStream;
use QuillStack\Http\Uri\Factory\UriFactory;
use QuillStack\Mocks\Request\MockLoginRequest;
use QuillStack\Mocks\Router\MockLoginController;
use QuillStack\Mocks\Router\MockRegisterController;
use QuillStack\Mocks\Router\MockUserController;

final class UserRouteTest extends TestCase
{
    public const SERVER = [
        'REQUEST_METHOD' => 'GET',
        'HTTP_HOST' => 'localhost:8000',
        'REQUEST_URI' => '/user/13/test',
        'SERVER_PROTOCOL' => '1.1',
    ];

    public function testRouter()
    {
        $router = new Router();
        $router->get('/user/:id/:name', MockUserController::class)->name('register');
        $router->get('/register', MockRegisterController::class)->name('register');
        $router->get('/login', MockLoginController::class)->name('login');

        $container = new Container([
            StreamInterface::class => InputStream::class,
            UriFactoryInterface::class => UriFactory::class,
            RequestFromGlobalsFactory::class => [
                'server' => static::SERVER,
            ],
        ]);

        $factory = $container->get(GivenRequestFromGlobalsFactory::class);
        $request = $factory->createGivenServerRequest(MockLoginRequest::class);

        $dispatcher = new Dispatcher($router);
        $route = $dispatcher->dispatch($request);
        dd($route);

        $this->assertEquals('register', $route->getName());
    }
}
