<?php

declare(strict_types=1);

namespace QuillStack\Router\RouteTree;

use QuillStack\Router\Route;

final class RouteTreeFinder
{
    /**
     * @param array $routeFinder
     * @param array $branch
     *
     * @return Route|null
     */
    public function findRoute(array &$routeFinder, array $branch): ?Route
    {
        foreach ($branch as $key) {
            $found = &$routeFinder[$key];

            if (!$found) {
                $routeFinder = &$routeFinder['*'];
            } else {
                $routeFinder = $found;
            }
        }

        if ($routeFinder instanceof Route) {
            return $routeFinder;
        }

        return null;
    }
}
