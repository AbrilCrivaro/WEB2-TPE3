<?php
    
    require_once 'libs/router.php';
    require_once 'app/controllers/top.api.controller.php';
    require_once 'config.php';
    
    $router = new Router();

     #                 endpoint        verbo          controller              metodo
     $router->addRoute('songs',        'GET'   ,   'topApiController',       'getAll');
     $router->addRoute('songs/:id',    'GET'   ,   'topApiController',       'get'   );
     $router->addRoute('songs/:id',    'DELETE',   'topApiController',       'delete');
     $router->addRoute('songs',        'POST'  ,   'topApiController',       'create');
     $router->addRoute('songs/:id',    'PUT'   ,   'topApiController',       'update');

     $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

