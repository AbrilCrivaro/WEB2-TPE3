<?php
require_once './app/models/artist.model.php';
require_once './app/models/song.model.php';
require_once './app/views/json.view.php';

class SongsApiController {
    private $songModel;
    private $artistModel;
    private $view;

    public function __construct() {
        $this->songModel = new SongModel();
        $this->artistModel = new ArtistModel();
        $this->view = new JSONView();
    }

    public function getAllSongs($req, $res) {

        $sort = null;
        if(isset($req->query->sort)){
            $sort = $req->query->sort;
        }

        $order = null;
        if(isset($req->query->order)){
            $order = $req->query->order;
        }

        $filter = null;
        if(isset($req->query->filter)){
            $filter = $req->query->filter;
        }

        $page = isset($req->query->page) ? (int)$req->query->page : 1;
        $limit = isset($req->query->limit) ? (int)$req->query->limit : 10; 
        $offset = ($page - 1) * $limit;


        $songs = $this->songModel->getAllSongs($filter, $sort, $order, $limit, $offset);

        if($songs == null){
            return $this->view->response('datos erroneos', 400);
        }

    
        foreach ($songs as $song) {
            $song->artist = $this->artistModel->getArtistById($song->id_artist);
        }

        return $this->view->response($songs, 200);
    }

    public function getSong($req, $res){
        $id = $req->params->id;

        $song = $this->songModel->getSongById($id);

        if($song == null){
            return $this->view->response('no existe su cancion', 404);
        }

        return $this->view->response($song, 200);
    }

    public function createSong($req, $res){

        if (empty($req->body->song_name) || empty($req->body->artist_id) || empty($req->body->lyrics) || empty($req->body->views) || empty($req->body->date)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        $artist_id = $req->body->artist_id;

        $artist_exist = $this->artistModel->getArtistById($artist_id);
        
        if ($artist_exist == null) {
            return $this->view->response("No existe el artista", 404);
        }

        $song_name = $req->body->song_name;

        $song_exist = $this->songModel->getSongByName($artist_id, $song_name);

        if ($song_exist != null) {
            return $this->view->response("Ya existe su cancion", 400);
        }

        $date = $req->body->date;
        $views = $req->body->views;
        $lyrics = $req->body->lyrics;



        $id = $this->songModel->insertSong($song_name, $date, $views, $artist_id, $lyrics);

        $song = $this->songModel->getSongById($id);

        return $this->view->response($song, 201);
    }

public function updateSong($req, $res){

    if (empty($req->params->id) || empty($req->body->song_name) || empty($req->body->date) || empty($req->body->views) || empty($req->body->lyrics)) { 
        return $this->view->response('Faltan completar datos', 400);
    }

    $song_id = $req->params->id;

    if($this->songModel->getSongById($song_id) == null){
        return $this->view->response('no existe la cancion', 404);
    }
    
    $song_name = $req->body->song_name;
    $date = $req->body->date;
    $views = $req->body->views;
    $lyrics = $req->body->lyrics;

    $this->songModel->updateSong($song_id, $song_name, $date, $views, $lyrics);

    $song = $this->songModel->getSongById($song_id);

    return $this->view->response($song, 200);
}

    public function deleteSong($req, $res) {
        if (empty($req->params->id)) {
            return $this->view->response('Falta completar el ID de la canción', 400);
        }

        $song_id = $req->params->id;

        if($this->songModel->getSongById($song_id) == null){
            return $this->view->response('no existe la cancion', 404);
        }

        $this->songModel->eraseSong($song_id);

        return $this->view->response('La cancion se elimino con exito', 200);
    }


}