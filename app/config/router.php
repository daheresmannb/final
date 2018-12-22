<?php

$router = $di->getRouter();


$router->add(
    '/login',
    [
        'controller' => 'Login',
        'action'     => 'Login',
    ]
);

$router->handle();
