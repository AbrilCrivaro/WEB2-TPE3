<?php
require_once './app/models/artist.model.php';
require_once './app/models/song.model.php';
require_once './app/views/json.view.php';

class topApiController {
    private $songModel;
    private $artistModel;
    private $view;

    public function __construct() {
        $this->songModel = new SongModel();
        $this->artistModel = new ArtistModel();
        $this->view = new JSONView();
    }

    public function getAll($req, $res) {
        $songs = $this->songModel->getAllSongs();

        foreach ($songs as $song) {
            $song->artist = $this->artistModel->getArtistById($song->id_artist);
        }

        return $this->view->response($songs);
    }

    public function get($req, $res){
        $id = $req->params->id;

        $song = $this->songModel->getSongById($id);

        return $this->view->response($song);
    }

    public function create($req, $res){

        if (empty($req->body->artist_name) || empty($req->body->artist_namenationality) || empty($req->body->img_artist) || empty($req->body->description)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        $artist_name = $req->body->artist_name;

        $artist_exist = $this->artistModel->artist_exist($artist_name);

        if ($artist_exist == $artist_name) {
            return $this->view->response("Error al insertar tarea", 500);
        }

        $nationality = $req->body->artist_namenationality;
        $img_artist = $req->body->img_artist;
        $description = $req->body->description;

        $id = $this->artistModel->insertArtist($artist_name, $nationality, $img_artist, $description);

        $artist = $this->artistModel->getArtistById($id);

        return $this->view->response($artist, 201);
    }
}