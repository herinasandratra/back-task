<?php

use SuperBlog\Model\TaskRepository;
use SuperBlog\Model\UserRepository;
use SuperBlog\Persistence\InMemoryTaskRepository;
use function DI\create;
use SuperBlog\Persistence\InMemoryUserRepository;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return [
    // Bind an interface to an implementation
    UserRepository::class => create(InMemoryUserRepository::class),
    TaskRepository::class => create(InMemoryTaskRepository::class),
    // Configure Twig
    Environment::class => function () {
        $loader = new FilesystemLoader(__DIR__ . '/../src/SuperBlog/Views');
        return new Environment($loader);
    },
];
