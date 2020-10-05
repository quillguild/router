<?php

declare(strict_types=1);

namespace QuillStack\Router;

interface RouterInterface
{
    /**
     * @param string $path
     * @param string $controller
     * @codeCoverageIgnore
     *
     * @return $this
     */
    public function get(string $path, string $controller): self;

    /**
     * @param string $name
     * @codeCoverageIgnore
     *
     * @return $this
     */
    public function name(string $name): self;

    /**
     * @codeCoverageIgnore
     *
     * @return array
     */
    public function getRoutes(): array;
}
