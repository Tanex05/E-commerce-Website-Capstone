<?php

/** Set Siderbar Item Active */

function setActive(array $routes) {
    if (is_array($routes)) {
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return 'active';
            }
        }
    }
}
