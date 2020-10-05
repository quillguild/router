<?php

declare(strict_types=1);

namespace QuillStack\Router;

interface RouterInterface
{
    /**
     * @param string $path
     * @param string $controller
     *
     * @return $this
     */
    public function get(string $path, string $controller): self;

    /**
     * @param string $name
     *
     * @return $this
     */
    public function name(string $name): self;

    /**
     * @return array
     */
    public function getRoutes(): array;
}
