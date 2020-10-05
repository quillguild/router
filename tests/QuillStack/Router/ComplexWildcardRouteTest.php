<?php

declare(strict_types=1);

namespace QuillStack\Router;

use QuillStack\Mocks\AbstractTest;
use QuillStack\Mocks\Request\MockLoginRequest;
use QuillStack\Mocks\Router\MockLoginController;
use QuillStack\Mocks\Router\MockRegisterController;
use QuillStack\Mocks\Router\MockUserController;

final class ComplexWildcardRouteTest extends AbstractTest
{
    public const REQUEST = MockLoginRequest::class;
    public const SERVER = [
        'REQUEST_METHOD' => 'GET',
        'HTTP_HOST' => 'localhost:8000',
        'REQUEST_URI' => '/user/13/name/15/test/12/extra/11/dog/3/forest',
        'SERVER_PROTOCOL' => '1.1',
    ];

    public function testSimpleWildcardRoute()
    {
        $router = new Router();
        $router->get(
            '/user/:id/:name/:test/:dir/:number/:more/:count/:animal/:age/:name',
            MockUserController::class
        )->name('user');
        $router->get('/register', MockRegisterController::class)->name('register');
        $router->get('/login', MockLoginController::class)->name('login');
        $route = $this->getRoute($router);

        $this->assertEquals('GET /user/:id/:name/:test/:dir/:number/:more/:count/:animal/:age/:name', $route->key);
        $this->assertEquals('user', $route->getName());
    }
}
