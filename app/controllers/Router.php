<?php
namespace App\controllers;

use FastRoute;

class Router
{
    public function __construct()
    {
        $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/home/{name:\d+}', ['App\controllers\HomeController', 'index']);
            // {id} must be a number (\d+)
            $r->addRoute('GET', '/about/{name:\d+}', ['App\controllers\HomeController', 'about']);
            $r->addRoute('GET', '/login', ['App\controllers\HomeController', 'login']);
            $r->addRoute('GET', '/logout', ['App\controllers\HomeController', 'logout']);
            $r->addRoute('GET', '/mail', ['App\controllers\HomeController', 'send_mail']);
            $r->addRoute('GET', '/create_posts', ['App\controllers\HomeController', 'createPosts']);
        });

// Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];

                $vars = $routeInfo[2];

                $class = new $handler[0];

                $method = $handler[1];

                call_user_func([$class, $method], $vars);
                break;
        }
    }

}