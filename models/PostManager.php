<?php
namespace Nicolas\FermeHaffner\Models;
require_once("Manager.php");

class PostManager extends Manager
{
    // Connexion à la base de données lors de l'instanciation
    public function __construct()
    {
        $this->db = $this->dbConnect();
    }

    // Récupération des 2 derniers articles
    public function getLastPosts()
    {
        $req = $this->db->query('SELECT id, title, content, image_name, DATE_FORMAT(creation_date, \'%d/%m/%Y\') AS creation_date_fr FROM posts WHERE online = 1 ORDER BY creation_date DESC LIMIT 0, 2');

        $posts = [];
        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
            $posts[] = new Post($data);
        }

        return $posts;
    }

    // Récupération du nombre d'articles
    public function getNumberOfPosts()
    {
        $req = $this->db->query('SELECT id FROM posts');
        $numberOfPosts = $req->rowCount();

        return $numberOfPosts;
    }

    // Récupération du nombre d'articles publiés
    public function getNumberOfOnlinePosts()
    {
        $req = $this->db->query('SELECT id FROM posts WHERE online = 1');
        $numberOfPosts = $req->rowCount();

        return $numberOfPosts;
    }

    // Récupération des articles publiés + pagination
    public function getOnlinePosts($start, $limit)
    {
        $req = $this->db->prepare('SELECT id, title, content, image_name, DATE_FORMAT(creation_date, \'%d/%m/%Y\') AS creation_date_fr FROM posts WHERE online = 1 ORDER BY creation_date DESC LIMIT :start, :offset');
        $req->bindValue('start', $start, \PDO::PARAM_INT);
        $req->bindValue('offset', $limit, \PDO::PARAM_INT);
        $req->execute();

        $posts = [];
        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
            $posts[] = new Post($data);
        }

        return $posts;
    }

    // Récupération d'un article
    public function getPost($postId)
    {
        $req = $this->db->prepare('SELECT id, title, content, image_name, DATE_FORMAT(creation_date, \'%d/%m/%Y\') AS creation_date_fr FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $post = $req->fetch(\PDO::FETCH_ASSOC);

        return new Post($post);
    }

    // Récupération de tous les articles
    public function getAllPosts($start, $limit)
    {
        $req = $this->db->prepare('SELECT id, title, content, image_name, DATE_FORMAT(creation_date, \'%d/%m/%Y\') AS creation_date_fr, online FROM posts ORDER BY creation_date DESC LIMIT :start, :offset');
        $req->bindValue('start', $start, \PDO::PARAM_INT);
        $req->bindValue('offset', $limit, \PDO::PARAM_INT);
        $req->execute();

        $posts = [];
        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
            $posts[] = new Post($data);
        }

        return $posts;
    }

    // Ajout d'un article
    public function insertPost($title, $content)
    {
        $req = $this->db->prepare('INSERT INTO posts(title, content, image_name, creation_date) VALUES(?, ?, ?, NOW())');
        $insertPost = $req->execute(array($title, $content, ''));
        $lastId = $this->db->lastInsertId();

        return $lastId;
    }

    // Ajout d'une image
    public function insertImage($postId, $imageName)
    {
        $req = $this->db->prepare('UPDATE posts SET image_name = ? WHERE id = ?');
        $insertImage = $req->execute(array($imageName, $postId));

        return $insertImage;
    }

    // Edition d'un article
    public function setEditPost($postId, $title, $content)
    {
        $req = $this->db->prepare('UPDATE posts SET title = ?, content = ? WHERE id = ?');
        $editPost = $req->execute(array($title, $content, $postId));

        return $editPost;
    }

    // Suppression d'un article et de ces commentaires
    public function deletePost($postId)
    {
        $req = $this->db->prepare('DELETE FROM posts WHERE id = ?');
        $deletePost = $req->execute(array($postId));

        if ($deletePost === false) {
            throw new \Exception('Impossible de supprimer cet article.');
        }
        else {
            $reqTwo = $this->db->prepare('DELETE FROM comments WHERE post_id = ?');
            $deleteComments = $reqTwo->execute(array($postId));
            
            return $deleteComments;
        }
    }

    // Rendre un article public
    public function setOnlinePost($postId)
    {
        $req = $this->db->prepare('UPDATE posts SET online = 1 WHERE id = ?');
        $onlinePost = $req->execute(array($postId));

        return $onlinePost;
    }

    // Rendre un article privé
    public function setOfflinePost($postId)
    {
        $req = $this->db->prepare('UPDATE posts SET online = 0 WHERE id = ?');
        $offlinePost = $req->execute(array($postId));

        return $offlinePost;
    }

    // Rechercher un article
    public function searchPosts($search)
    {
        $req = $this->db->prepare('
            SELECT id, title, content, image_name, DATE_FORMAT(creation_date, \'%d/%m/%Y\') AS creation_date_fr, online 
            FROM posts 
            WHERE CONCAT(title, content) LIKE ? AND online = 1
            ORDER BY creation_date 
            DESC');
        $req->execute(array("%" . $search . "%"));

        $posts = [];
        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
            $posts[] = new Post($data);
        }

        return $posts;
    }
}