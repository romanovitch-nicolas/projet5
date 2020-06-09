<?php
namespace Nicolas\FermeHaffner\Models;
require_once("Manager.php");

class CommentManager extends Manager
{
    // Connexion à la base de données lors de l'instanciation
    public function __construct()
    {
        $this->db = $this->dbConnect();
    }
    
    // Récupération des commentaires d'un article
    public function getComments($postId, $start, $limit)
    {
        $req = $this->db->prepare('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date_fr, report FROM comments WHERE post_id = :id ORDER BY comment_date DESC LIMIT :start, :offset');
        $req->bindValue('id', $postId, \PDO::PARAM_INT);
        $req->bindValue('start', $start, \PDO::PARAM_INT);
        $req->bindValue('offset', $limit, \PDO::PARAM_INT);
        $req->execute();

        $comments = [];
        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
            $comments[] = new Comment($data);
        }

        return $comments;
    }

    // Récupération du nombre de commentaires
    public function getNumberOfComments()
    {
        $req = $this->db->query('SELECT id FROM comments');
        $numberOfComments = $req->rowCount();

        return $numberOfComments;
    }

    // Récupération du nombre de commentaires d'un article
    public function getNumberOfCommentsPost($postId)
    {
        $req = $this->db->prepare('SELECT id FROM comments WHERE post_id = ?');
        $req->execute(array($postId));
        $numberOfComments = $req->rowCount();

        return $numberOfComments;
    }

    // Récupération de tous les commentaires
    public function getAllComments($start, $limit)
    {
        $req = $this->db->prepare('SELECT posts.id AS tableposts_id, posts.title AS tableposts_title,
                                comments.id, comments.post_id, comments.author, comments.mail, comments.comment, DATE_FORMAT(comments.comment_date, \'%d/%m/%Y, %Hh%i\') AS comment_date_fr, comments.report
                                FROM posts, comments
                                WHERE posts.id = comments.post_id
                                ORDER BY comments.report DESC, comment_date DESC
                                LIMIT :start, :offset');
        $req->bindValue('start', $start, \PDO::PARAM_INT);
        $req->bindValue('offset', $limit, \PDO::PARAM_INT);
        $req->execute();
        
        $comments = [];
        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
            $comments[] = new Comment($data);
        }

        return $comments;
    }

    // Ajout d'un commentaire
    public function insertComment($postId, $author, $mail, $comment)
    {
        $req = $this->db->prepare('INSERT INTO comments(post_id, author, mail, comment, comment_date) VALUES(?, ?, ?, ?, NOW())');
        $insertComment = $req->execute(array($postId, $author, $mail, $comment));

        return $insertComment;
    }

    // Signalement d'un commentaire
    public function setReporting($commentId)
    {
        $req = $this->db->prepare('UPDATE comments SET report = 1 WHERE id = ?');
        $report = $req->execute(array($commentId));

        return $report;
    }

    // Approbation d'un commentaire signalé
    public function setDeleteReporting($commentId)
    {
        $req = $this->db->prepare('UPDATE comments SET report = 0 WHERE id = ?');
        $deleteReport = $req->execute(array($commentId));

        return $deleteReport;
    }

    // Suppression d'un commentaire
    public function deleteComment($commentId)
    {
        $req = $this->db->prepare('DELETE FROM comments WHERE id = ?');
        $deleteComment = $req->execute(array($commentId));

        return $deleteComment;
    }
}