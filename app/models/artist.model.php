<?php

require_once 'app/models/song.model.php';
require_once 'app/models/model.php';

class ArtistModel extends Model{
    private $songModel;

    public function __construct() {
        parent::__construct();

        $this->songModel = new SongModel();
    }

    public function getAllArtists($filter = false, $sort = false, $order = false, $limit = 10, $offset = 0) {

        $sql = 'SELECT * FROM artists';

        if($filter != null) {
            $sql .= " WHERE artist_nationality = :filter";
        }


        if($sort) {
            switch(strtolower($sort)) {
                case 'artist_name':
                    $sql .= ' ORDER BY artist_name';
                    break;
                case 'artist_nationality':
                    $sql .= ' ORDER BY artist_nationality';
                    break;
                default:
                return;
            }
            if ($order) {
                switch (strtoupper($order)) {
                    case 'DESC':
                        $sql .= ' DESC';
                        break;
                    case 'ASC':
                        $sql .= ' ASC';
                        break;
                }
            }
        }
        
        $sql .= " LIMIT :limit OFFSET :offset";

        $query = $this->db->prepare($sql);
            $query->bindValue(':limit', $limit, PDO::PARAM_INT);
            $query->bindValue(':offset', $offset, PDO::PARAM_INT);
        if($filter != null){
            $query->bindValue(':filter', $filter, PDO::PARAM_INT);
        }
        $query->execute();

        $artists = $query->fetchAll(PDO::FETCH_OBJ);


        return $artists;
    }

    public function getArtistById($id_artist) {
        $query = $this->db->prepare('SELECT * FROM artists WHERE id_artist = ?');
        $query->execute([$id_artist]);
        $artist = $query->fetch(PDO::FETCH_OBJ);
        return $artist;
    }

    public function insertArtist($artist_name, $nationality, $img_artist, $description) { 
        
        $query = $this->db->prepare('INSERT INTO artists(artist_name, artist_nationality, img_artist, description) VALUES (?, ?, ?, ?)');
        $query->execute([$artist_name, $nationality, $img_artist, $description]);

        $id = $this->db->lastInsertId();
    
        return $id;

    }

    public function updateArtist($artist_id, $artist_name, $nationality, $img_artist, $description) {        
        $query = $this->db->prepare('UPDATE artists SET artist_name = ?, artist_nationality = ?, img_artist = ?, description = ? WHERE id_artist = ?');
        $query->execute([$artist_name, $nationality, $img_artist, $description , $artist_id]);
    }

    public function eraseArtist($id) {
        $id_songs = $this->songModel->getSongByArtist($id);

        foreach ($id_songs as $song) {
            $this->songModel->eraseSong($song->id_song);
        }

        $query = $this->db->prepare('DELETE FROM artists WHERE id_artist = ?');
        $query->execute([$id]);
    }

    public function artist_exist($artist_name){
        $query = $this->db->prepare('SELECT * FROM artists WHERE artist_name = ?');
        $query->execute([$artist_name]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}