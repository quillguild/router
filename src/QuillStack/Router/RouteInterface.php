<?php

declare(strict_types=1);

namespace QuillStack\Router;

interface RouteInterface
{
    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self;

    /**
     * @return string
     */
    public function getName(): string;
}
