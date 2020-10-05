<?php

declare(strict_types=1);

namespace QuillStack\Router;

final class Route implements RouteInterface
{
    /**
     * @var string
     */
    public const METHOD_GET = 'GET';

    /**
     * @var string
     */
    private string $method;

    /**
     * @var string
     */
    private string $path;

    /**
     * @var string
     */
    private string $controller;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
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
     * {@inheritDoc}
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->name;
    }
}
