<?php
require_once './app/models/artist.model.php';
require_once './app/models/song.model.php';
require_once './app/views/json.view.php';

class ArtistsApiController {

    private $songModel;
    private $artistModel;
    private $view;

    public function __construct() {
        $this->songModel = new SongModel();
        $this->artistModel = new ArtistModel();
        $this->view = new JSONView();
    }

    public function createArtist($req, $res){

        if (empty($req->body->artist_name) || empty($req->body->artist_nationality) || empty($req->body->img_artist) || empty($req->body->description)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        $artist_name = $req->body->artist_name;

        $artist_exist = $this->artistModel->artist_exist($artist_name);

        if ($artist_exist != null) {
            return $this->view->response("Error al insertar por duplicacion", 400);
        }

        $nationality = $req->body->artist_nationality;
        $img_artist = $req->body->img_artist;
        $description = $req->body->description;

        $id = $this->artistModel->insertArtist($artist_name, $nationality, $img_artist, $description);

        $artist = $this->artistModel->getArtistById($id);

        return $this->view->response($artist, 201);
    }

    public function getAllArtists($req, $res) {

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


        $artists = $this->artistModel->getAllArtists($filter, $sort, $order, $limit, $offset);

        if($artists == null){
            return $this->view->response('datos erroneos', 400);
        }

        return $this->view->response($artists, 200);
    }

    public function getArtist($req, $res){

        $id = $req->params->id;

        $artist = $this->artistModel->getArtistById($id);

        if($artist == null){
            return $this->view->response('no existe su artista', 404);
        }

        return $this->view->response($artist, 200);
    }

    public function updateArtist($req, $res){

        if (empty($req->params->id) || empty($req->body->artist_name) || empty($req->body->artist_nationality) || empty($req->body->img_artist) || empty($req->body->description)) { 
            return $this->view->response('Faltan completar datos', 400);
        }
    
        $artist_id = $req->params->id;

        if($this->artistModel->getArtistById($artist_id) == null){
            return $this->view->response('no existe el artista', 404);
        }

        $artist_name = $req->body->artist_name;
        $nationality = $req->body->artist_nationality;
        $img_artist = $req->body->img_artist;
        $description = $req->body->description;

    
        $this->artistModel->updateArtist($artist_id, $artist_name, $nationality, $img_artist, $description);
    
        $artist = $this->artistModel->getArtistById($artist_id);
    
        return $this->view->response($artist, 200);
    }

    public function deleteArtist($req, $res) {
        if (empty($req->params->id)) {
            return $this->view->response('Falta completar el ID del artista', 400);
        }

        $artist_id = $req->params->id;

        if($this->artistModel->getArtistById($artist_id) == null){
            return $this->view->response('no existe el artista', 404);
        }

        $this->artistModel->eraseArtist($artist_id);

        return $this->view->response('el artista se elimino con exito', 200);
    }
}