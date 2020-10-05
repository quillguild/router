<?php

declare(strict_types=1);

namespace QuillStack\Router;

interface RouteInterface
{
    /**
     * @param string $name
     * @codeCoverageIgnore
     *
     * @return $this
     */
    public function setName(string $name): self;

    /**
     * @codeCoverageIgnore
     *
     * @return string
     */
    public function getName(): string;
}
