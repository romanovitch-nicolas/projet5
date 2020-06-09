<?php
namespace Nicolas\FermeHaffner\Models;
require_once("Manager.php");

class ShopManager extends Manager
{
    // Connexion à la base de données lors de l'instanciation
    public function __construct()
    {
        $this->db = $this->dbConnect();
    }
    
    // Récupération de la liste des points de ventes
	public function getShops()
    {
        $req = $this->db->query('SELECT * FROM shops ORDER BY name');

        $shops = [];
        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
            $shops[] = new Shop($data);
        }

        return $shops;
    }

    // Ajout d'un point de vente
    public function insertShop($name, $adress, $city, $postal, $latitude, $longitude)
    {
        $req = $this->db->prepare('INSERT INTO shops(name, adress, city, postal_code, latitude, longitude) VALUES(?, ?, ?, ?, ?, ?)');
        $insertShop = $req->execute(array($name, $adress, $city, $postal, $latitude, $longitude));

        return $insertShop;
    }

    // Suppression d'un point de vente
    public function deleteShop($shopId)
    {
        $req = $this->db->prepare('DELETE FROM shops WHERE id = ?');
        $deleteShop = $req->execute(array($shopId));

        return $deleteShop;
    }
}