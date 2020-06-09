<?php
namespace Nicolas\FermeHaffner\Models;
require_once("Manager.php");

class UserManager extends Manager
{
	// Connexion à la base de données lors de l'instanciation
    public function __construct()
    {
        $this->db = $this->dbConnect();
    }
	
	// Récupération des informations de l'utilisateur
    public function getUserInfo($login)
    {
        $req = $this->db->prepare('SELECT * FROM users WHERE login = ?');
        $req->execute(array($login));
        $userinfo = $req->fetch(\PDO::FETCH_ASSOC);

        return new User($userinfo);
    }
}