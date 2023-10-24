<?php

use FastRoute\RouteCollector;

$container = require __DIR__ . '/../app/bootstrap.php';

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    // @route for api user
    $r->addRoute('POST','/users', ['SuperBlog\Controller\UserController','create']);

    //@route for api tasks
    $r->addRoute('POST','/tasks', ['SuperBlog\Controller\TaskController','create']);
    $r->addRoute('GET','/tasks/{id}', ['SuperBlog\Controller\TaskController','read']);
    $r->addRoute('PUT','/tasks/{id}', ['SuperBlog\Controller\TaskController','update']);
    $r->addRoute('DELETE','/tasks/{id}', ['SuperBlog\Controller\TaskController','delete']);
    $r->addRoute('GET','/tasks', ['SuperBlog\Controller\TaskController','list']);
});

$route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 Not Found';
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        echo '405 Method Not Allowed';
        break;

    case FastRoute\Dispatcher::FOUND:
        $controller = $route[1];
        $parameters = $route[2];

        // We could do $container->get($controller) but $container->call()
        // does that automatically
        $container->call($controller, $parameters);
        break;
}
