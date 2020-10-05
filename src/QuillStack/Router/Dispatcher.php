<?php

declare(strict_types=1);

namespace QuillStack\Router;

use Psr\Http\Message\ServerRequestInterface;

final class Dispatcher implements DispatcherInterface
{
    /**
     * @var Router
     */
    private Router $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch(ServerRequestInterface $serverRequest): ?Route
    {
        $exactMatch = $this->findExactMatch($serverRequest);

        return $exactMatch ?? $this->findWildcardMatch($serverRequest);
    }

    /**
     * @param ServerRequestInterface $serverRequest
     *
     * @return Route|null
     */
    private function findExactMatch(ServerRequestInterface $serverRequest): ?Route
    {
        $routes = $this->router->getRoutes();
        $key = $this->getKeyForExactMatch($serverRequest);

        return $routes[$key] ?? null;
    }

    /**
     * @param ServerRequestInterface $serverRequest
     *
     * @return Route|null
     */
    private function findWildcardMatch(ServerRequestInterface $serverRequest): ?Route
    {
        $key = $this->getKeyForWildcardMatch($serverRequest);
        $tree = $this->router->getTree();

        return $this->findRoute(
            $tree,
            $this->getBranch($key)
        );
    }

    /**
     * @param string $key
     *
     * @return array
     */
    private function getBranch(string $key): array
    {
        $branch = explode('/', $key);
        $branch[] = '';

        return $branch;
    }

    /**
     * @param ServerRequestInterface $serverRequest
     *
     * @return string
     */
    private function getKeyForExactMatch(ServerRequestInterface $serverRequest): string
    {
        return $serverRequest->getMethod() . ' ' . $serverRequest->getRequestTarget();
    }

    /**
     * @param ServerRequestInterface $serverRequest
     *
     * @return string
     */
    private function getKeyForWildcardMatch(ServerRequestInterface $serverRequest): string
    {
        return $serverRequest->getMethod() . $serverRequest->getRequestTarget();
    }

    /**
     * @param array $routeFinder
     * @param array $branch
     *
     * @return Route|null
     */
    private function findRoute(array &$routeFinder, array $branch): ?Route
    {
        foreach ($branch as $key) {
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
