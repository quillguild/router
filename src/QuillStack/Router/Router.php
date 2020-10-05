<?php

declare(strict_types=1);

namespace QuillStack\Router;

use QuillStack\Http\Request\ServerRequest;

final class Router implements RouterInterface
{
    /**
     * @var array
     */
    private array $routes;

    /**
     * @var Route
     */
    private Route $currentRoute;

    /**
     * @var array
     */
    private array $tree = [];

    /**
     * @param $tree
     * @param $indexes
     * @param $value
     */
    private function applyChain(&$tree, $indexes, $value)
    {
        if (count($indexes) === 0) {
            $tree = [
                '' => $this->currentRoute
            ];
        } else {
            $index = array_shift($indexes);

            if ($this->hasWildcard($index)) {
                $index = '*';
            }

            $this->applyChain($tree[$index], $indexes, $value);
        }
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    private function hasWildcard(string $path): bool
    {
        return is_string(strstr($path, ':'));
    }

    /**
     * @param string $method
     * @param string $path
     * @param string $controller
     *
     * @return $this
     */
    private function add(string $method, string $path, string $controller): self
    {
        $this->currentRoute = new Route($method, $path, $controller);
        $this->updateCurrentRoute();

        if ($this->hasWildcard($path)) {
            $treePath = $method . $path;
            $parts = explode('/', trim($treePath, '/'));
            $this->applyChain($this->tree, $parts, array());
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function name(string $name): self
    {
        $this->currentRoute->setName($name);
        $this->updateCurrentRoute();

        return $this;
    }

    private function updateCurrentRoute(): void
    {
        $this->routes[$this->currentRoute->getKey()] = $this->currentRoute;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @return array
     */
    public function getTree(): array
    {
        return $this->tree;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $path, string $controller): RouterInterface
    {
        return $this->add(ServerRequest::METHOD_GET, $path, $controller);
    }

    /**
     * {@inheritDoc}
     */
    public function post(string $path, string $controller): RouterInterface
    {
        return $this->add(ServerRequest::METHOD_POST, $path, $controller);
    }
}
