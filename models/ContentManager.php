<?php
namespace Nicolas\FermeHaffner\Models;
require_once("Manager.php");

class ContentManager extends Manager
{
    // Connexion à la base de données lors de l'instanciation
    public function __construct()
    {
        $this->db = $this->dbConnect();
    }

    // Récupération du contenu d'une page
	public function getContent($flag)
    {
        $req = $this->db->prepare('SELECT * FROM contents WHERE flag  = ?');
        $req->execute(array($flag));
        $data = $req->fetch(\PDO::FETCH_ASSOC);

        return new Content($data);
    }

    // Modification de la bannière
    public function setEditBanner($flag, $imageName)
    {
        $req = $this->db->prepare('UPDATE contents SET banner = ? WHERE flag = ?');
        $editBanner = $req->execute(array($imageName, $flag));

        return $editBanner;
    }

    // Modification du texte 1
    public function setEditTextOne($flag, $text)
    {
        $req = $this->db->prepare('UPDATE contents SET text_1 = ? WHERE flag = ?');
        $editText = $req->execute(array($text, $flag));

        return $editText;
    }

    // Modification du texte 2
    public function setEditTextTwo($flag, $text)
    {
        $req = $this->db->prepare('UPDATE contents SET text_2 = ? WHERE flag = ?');
        $editText = $req->execute(array($text, $flag));

        return $editText;
    }

    // Modification de l'image 1
    public function setEditImageOne($flag, $imageName)
    {
        $req = $this->db->prepare('UPDATE contents SET image_1 = ? WHERE flag = ?');
        $editImage = $req->execute(array($imageName, $flag));

        return $editImage;
    }

    // Modification de l'image 2
    public function setEditImageTwo($flag, $imageName)
    {
        $req = $this->db->prepare('UPDATE contents SET image_2 = ? WHERE flag = ?');
        $editImage = $req->execute(array($imageName, $flag));

        return $editImage;
    }
}