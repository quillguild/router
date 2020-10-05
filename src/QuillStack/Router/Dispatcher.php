<?php

declare(strict_types=1);

namespace QuillStack\Router;

use Psr\Http\Message\ServerRequestInterface;

final class Dispatcher
{
    /**
     * @var Router
     */
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function dispatch(ServerRequestInterface $serverRequest): ?Route
    {
        $key = $serverRequest->getMethod() . ' ' . $serverRequest->getRequestTarget();
        $routes = $this->router->getRoutes();

        if (isset($routes[$key])) {
            return $routes[$key];
        }

        $key = $serverRequest->getMethod() . $serverRequest->getRequestTarget();
        $branch = explode('/', $key);
        $tree = $this->router->getTree();

        $routeFinder = &$tree;

        foreach($branch as $key) {
            $found = &$routeFinder[$key];

            if (!$found) {
                $routeFinder = &$routeFinder['*'];
            } else {
                $routeFinder = $found;
            }
        }

        if ($routeFinder instanceof Route) {
            return $routeFinder;
        }

        return null;
    }
}
