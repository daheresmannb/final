<?php

$router = $di->getRouter();


$router->add(
    '/login',
    [
        'controller' => 'Login',
        'action'     => 'Login',
    ]
);

$router->add(
    '/login-v',
    [
        'controller' => 'Login',
        'action'     => 'loginV',
    ]
);

$router->add(
    '/home',
    [
        'controller' => "Vistas",
        'action' 	 => 'index'
    ]
);

$router->add(
    '/alumnos',
    [
        'controller' => "Vistas",
        'action'     => 'mostrar'
    ]
);





$router->add(
    '/botones-alumnos',
    [
        'controller' => "Vistas",
        'action'     => 'btnalu'
    ]
);

$router->add(
    '/alumnos/registrar/v',
    [
        'controller' => "Vistas",
        'action'     => 'registrar'
    ]
);

$router->add(
    '/alumnos/eliminar/v',
    [
        'controller' => "Vistas",
        'action'     => 'eliminar'
    ]
);


/////// CRUD ALUMNOS //////// 

$router->add(
    '/alumnos/crear',
    [
        'controller' => 'Alumnos',
        'action'     => 'create',
    ]
);

$router->add(
    '/alumnos/obtener',
    [
        'controller' => 'Alumnos',
        'action'     => 'read',
    ]
);

$router->add(
    '/alumnos/actualizar',
    [
        'controller' => 'Alumnos',
        'action'     => 'Login',
    ]
);

$router->add(
    '/alumnos/eliminar',
    [
        'controller' => "Alumnos",
        'action'     => 'delete'
    ]
);
///////////////////////////////
$router->handle();
