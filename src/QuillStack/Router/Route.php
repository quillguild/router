<?php

declare(strict_types=1);

namespace QuillStack\Router;

final class Route
{
    public const METHOD_GET = 'GET';

    private string $method;
    private string $path;
    private string $controller;
    private string $name;
    public string $key;

    /**
     * @param string $method
     * @param string $path
     * @param string $controller
     */
    public function __construct(string $method, string $path, string $controller)
    {
        $this->method = $method;
        $this->path = $path;
        $this->controller = $controller;
        $this->key = "{$method} {$path}";
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
