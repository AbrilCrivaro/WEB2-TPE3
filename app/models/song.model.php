<?php 

require_once 'app/models/model.php';

class SongModel extends Model{

    public function getAllSongs($sort = false, $order = false, $limit = 10, $offset = 0) {

        $sql = 'SELECT * FROM songs';

        if($sort) {
            switch(strtolower($sort)) {
                case 'views':
                    $sql .= ' ORDER BY views';
                    break;
                case 'release_date':
                    $sql .= ' ORDER BY release_date';
                    break;
                case 'song_name':
                    $sql .= ' ORDER BY song_name';
                    break;
                case 'id_artist':
                    $sql .= ' ORDER BY id_artist';
                break;
                case 'lyrics_song':
                    $sql .= ' ORDER BY lyrics_song';
                break;
                case 'id_song':
                    $sql .= ' ORDER BY id_song';
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
        $query->execute();

        $songs = $query->fetchAll(PDO::FETCH_OBJ);

        return $songs;
    }

    public function getSongById($id) {
        $query = $this->db->prepare("SELECT * FROM songs WHERE id_song = ?");
        $query->execute([$id]);
        $song = $query->fetch(PDO::FETCH_OBJ);

        return $song;
    }

    public function getSongByArtist($id){
        $query = $this->db->prepare("SELECT * FROM songs WHERE id_artist = ?");
        $query->execute([$id]);
        $songartists = $query->fetchAll(PDO::FETCH_OBJ);

        return $songartists;
    }

    public function getSongsOptions(){
        $query = $this->db->prepare("SELECT id_song, song_name FROM songs");
        $query->execute();


        $options = "";
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $options .= "<option value='" . $row['id_song'] . "'>" . $row['song_name'] . "</option>";
        }

        return $options;
    }

    public function insertSong($song_name, $date, $views, $artist_id, $lyrics) { 
        $query = $this->db->prepare('INSERT INTO songs(song_name, release_date, views, id_artist, lyrics_song) VALUES (?, ?, ?, ?, ?)');
        $query->execute([$song_name, $date, $views, $artist_id, $lyrics]);
    
        $id = $this->db->lastInsertId();
    
        return $id;
    }

    public function updateSong($song_id, $song_name, $date, $views, $lyrics) {        
        $query = $this->db->prepare('UPDATE songs SET song_name = ?, release_date = ?, views = ?, lyrics_song = ? WHERE id_song = ?');
        $query->execute([$song_name, $date, $views, $lyrics , $song_id]);
    }

    public function eraseSong($id) {
        $query = $this->db->prepare('DELETE FROM songs WHERE id_song = ?');
        $query->execute([$id]);
    }



}