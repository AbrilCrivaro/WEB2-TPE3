<?php 

class userModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=top_songs;charset=utf8', 'root', '');
    }

    public function getUserByUsername($email){
        $query = $this->db->prepare('SELECT * FROM user WHERE email = ?');
        $query->execute([$email]);

        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;
    }
    
 }