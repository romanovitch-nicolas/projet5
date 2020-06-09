<?php
namespace Nicolas\FermeHaffner\Models;
require_once("Manager.php");

class ProductManager extends Manager
{
    // Connexion à la base de données lors de l'instanciation
    public function __construct()
    {
        $this->db = $this->dbConnect();
    }
    
    // Récupération des catégories de produits
    public function getCategories()
    {
        $categories = $this->db->query('SELECT * FROM categories ORDER BY id');

        return $categories;
    }

    // Récupération d'une catégorie
    public function getCategory($categoryId)
    {
        $req = $this->db->prepare('SELECT * FROM categories WHERE id = ?');
        $req->execute(array($categoryId));
        $data = $req->fetch();

        return $data;
    }
    
    // Récupération du nombre de produits
    public function getNumberOfProducts()
    {
        $req = $this->db->query('SELECT id FROM products');
        $numberOfProducts = $req->rowCount();

        return $numberOfProducts;
    }

    // Récupération du nombre de produits d'une catégorie
    public function getNumberOfProductsCategory($categoryId)
    {
        $req = $this->db->prepare('SELECT id FROM products WHERE category_id = ?');
        $req->execute(array($categoryId));
        $numberOfProducts = $req->rowCount();

        return $numberOfProducts;
    }

    // Récupération d'un produit
    public function getProduct($productId)
    {
        $req = $this->db->prepare('SELECT categories.name AS tablecategories_name, products.id, products.category_id, products.name, products.description, products.image_name, DATE_FORMAT(products.creation_date, \'%d/%m/%Y\') AS creation_date_fr
                                FROM categories, products
                                WHERE categories.id = products.category_id AND products.id = ?
                                ORDER BY products.name');
        $req->execute(array($productId));
        $product = $req->fetch(\PDO::FETCH_ASSOC);

        return new Product($product);
    }

    // Récupération de 2 produits au hasard
    public function getRandomProducts()
    {
        $req = $this->db->query('SELECT id, name, description, image_name FROM products ORDER BY rand() LIMIT 2');

        $products = [];
        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
            $products[] = new Product($data);
        }

        return $products;
    }

    // Récupération d'une catégorie de produits
    public function getProducts($categoryId, $start, $limit)
    {
        $req = $this->db->prepare('SELECT categories.id AS tablecategories_id, categories.name AS tablecategories_name,
                                products.id, products.category_id, products.name, products.description, products.image_name, DATE_FORMAT(products.creation_date, \'%d/%m/%Y\') AS creation_date_fr
                                FROM categories, products
                                WHERE categories.id = products.category_id AND products.category_id = :id
                                ORDER BY products.name
                                LIMIT :start, :offset');
        $req->bindValue('id', $categoryId, \PDO::PARAM_INT);
        $req->bindValue('start', $start, \PDO::PARAM_INT);
        $req->bindValue('offset', $limit, \PDO::PARAM_INT);
        $req->execute();

        $products = [];
        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
            $products[] = new Product($data);
        }

        return $products;
    }

    // Récupération des 5 dernieres produits
    public function getLastProducts()
    {
        $req = $this->db->query('SELECT id, category_id, name, description, image_name, DATE_FORMAT(creation_date, \'%d/%m/%Y\') AS creation_date_fr FROM products ORDER BY creation_date DESC LIMIT 0, 5');

        $products = [];
        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
            $products[] = new Product($data);
        }

        return $products;
    }

    // Récupération de tous les produits
    public function getAllProducts($start, $limit)
    {
        $req = $this->db->prepare('SELECT categories.id AS tablecategories_id, categories.name AS tablecategories_name,
                                products.id, products.category_id, products.name, products.description, products.image_name, DATE_FORMAT(products.creation_date, \'%d/%m/%Y\') AS creation_date_fr
                                FROM categories, products
                                WHERE categories.id = products.category_id
                                ORDER BY products.name
                                LIMIT :start, :offset');

        $req->bindValue('start', $start, \PDO::PARAM_INT);
        $req->bindValue('offset', $limit, \PDO::PARAM_INT);
        $req->execute();

        $products = [];
        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
            $products[] = new Product($data);
        }

        return $products;
    }

    // Ajout d'un produit
    public function insertProduct($name, $description, $category)
    {
        $req = $this->db->prepare('INSERT INTO products(category_id, name, description, image_name, creation_date) VALUES(?, ?, ?, ?, NOW())');
        $insertProduct = $req->execute(array($category, $name, $description, ''));
        $lastId = $this->db->lastInsertId();

        return $lastId;
    }

    // Ajout d'une image
    public function insertImage($productId, $imageName)
    {
        $req = $this->db->prepare('UPDATE products SET image_name = ? WHERE id = ?');
        $insertImage = $req->execute(array($imageName, $productId));

        return $insertImage;
    }

    // Edition d'un produit
    public function setEditProduct($productId, $name, $description, $category)
    {
        $req = $this->db->prepare('UPDATE products SET category_id = ?, name = ?, description = ? WHERE id = ?');
        $editProduct = $req->execute(array($category, $name, $description, $productId));

        return $editProduct;
    }

    // Suppression d'un produit
    public function deleteProduct($productId)
    {
        $req = $this->db->prepare('DELETE FROM products WHERE id = ?');
        $deleteProduct = $req->execute(array($productId));

        return $deleteProduct;
    }

    // Rechercher un produit
    public function searchProducts($search)
    {
        $req = $this->db->prepare('SELECT * FROM products WHERE CONCAT(name, description) LIKE ? ORDER BY name');
        $req->execute(array("%" . $search . "%"));

        $products = [];
        while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
            $products[] = new Product($data);
        }

        return $products;
    }
}