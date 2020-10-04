<?php

declare(strict_types=1);

namespace QuillStack\Router;

final class Router
{
    private array $routes;
    private Route $currentRoute;

    public function get(string $path, string $controller): self
    {
        $this->currentRoute = new Route(Route::METHOD_GET, $path, $controller);
        $this->updateCurrentRoute();

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
}
