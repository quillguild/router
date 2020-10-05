<?php

declare(strict_types=1);

namespace QuillStack\Router;

interface RouteInterface
{
    /**
     * @param string $name
     * @codeCoverageIgnore
     *
     * @return RouteInterface
     */
    public function setName(string $name): RouteInterface;

    /**
     * @codeCoverageIgnore
     *
     * @return string
     */
    public function getName(): string;
}
