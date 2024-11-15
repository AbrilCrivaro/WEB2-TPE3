<?php
    
    require_once 'libs/router.php';
    require_once 'app/controllers/songs.api.controller.php';
    require_once 'config.php';
    
    $router = new Router();

    # Song router

     #                 endpoint        verbo            controller                metodo
     $router->addRoute('songs',        'GET'   ,   'SongsApiController',       'getAllSongs');
     $router->addRoute('songs/:id',    'GET'   ,   'SongsApiController',       'getSong'   );
     $router->addRoute('songs/:id',    'DELETE',   'SongsApiController',       'deleteSong');
     $router->addRoute('songs',        'POST'  ,   'SongsApiController',       'createSong');
     $router->addRoute('songs/:id',    'PUT'   ,   'SongsApiController',       'updateSong');


    # Artist router

    #                 endpoint          verbo            controller                  metodo
    $router->addRoute('artists',        'GET'   ,   'ArtistApiController',       'getAllArtist');
    $router->addRoute('artists/:id',    'GET'   ,   'ArtistApiController',       'getArtist'   );
    $router->addRoute('artists/:id',    'DELETE',   'ArtistApiController',       'deleteArtist');
    $router->addRoute('artists',        'POST'  ,   'ArtistApiController',       'createArtist');
    $router->addRoute('artists/:id',    'PUT'   ,   'ArtistApiController',       'updateArtist');

     $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

