<?php

declare(strict_types=1);

namespace QuillStack\Router;

final class Router
{
    private array $routes;
    private Route $currentRoute;
    private array $tree = [];

    private function applyChain(&$arr, $indexes, $value)
    {
        if (!is_array($indexes)) {
            return;
        }

        if (count($indexes) === 0) {
            $arr = $this->currentRoute;
        } else {
            $index = array_shift($indexes);

            if ($this->hasWildcard($index)) {
                $index = '*';
            }

            $this->applyChain($arr[$index], $indexes, $value);
        }
    }

    private function hasWildcard(string $path)
    {
        return strstr($path, ':');
    }

    public function get(string $path, string $controller): self
    {
        $this->currentRoute = new Route(Route::METHOD_GET, $path, $controller);
        $this->updateCurrentRoute();

        if ($this->hasWildcard($path)) {
            $treePath = Route::METHOD_GET . $path;
            $parts = explode('/', trim($treePath, '/'));
            $this->applyChain($this->tree, $parts, array());
        }

        return $this;
    }

    public function name(string $name): self
    {
        $this->currentRoute->setName($name);
        $this->updateCurrentRoute();

        return $this;
    }

    private function updateCurrentRoute(): void
    {
        $this->routes[$this->currentRoute->key] = $this->currentRoute;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function getTree(): array
    {
        return $this->tree;
    }
}
