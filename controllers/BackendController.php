<?php
namespace Nicolas\FermeHaffner\Controllers;

use \Nicolas\FermeHaffner\Models\CommentManager;
use \Nicolas\FermeHaffner\Models\ContentManager;
use \Nicolas\FermeHaffner\Models\PostManager;
use \Nicolas\FermeHaffner\Models\ProductManager;
use \Nicolas\FermeHaffner\Models\ShopManager;
use \Nicolas\FermeHaffner\Models\UserManager;

class BackendController
{   
    // Connexion
    public function connect()
    {
        $userManager = new UserManager();
        
        if (!empty($_POST["login"]) AND !empty($_POST["pass"])) {
            $login = htmlspecialchars($_POST["login"]);
            $pass = htmlspecialchars($_POST["pass"]);
            $userinfo = $userManager->getUserInfo($login);
            $passverif = password_verify($pass, $userinfo->pass());
            if ($passverif) {
                session_start();
                $_SESSION['login'] = $login;
                    if(isset($_POST['autoconnect']))
                    {
                        setcookie('login', $login, time() + 365*24*3600, null, null, false, true);
                    }
                header('Location: ' . LINK_ADMIN);
            }
            else {
                $return = 'Mauvais identifiant ou mot de passe.';
            }
        }
        else {
            $return = 'Tous les champs ne sont pas remplis.';
        }

        require('views/frontend/connectView.php');
    }

    // Déconnexion
    public function disconnect()
    { 
        $_SESSION = array();
        session_destroy();
        setcookie('login', '');
        header("Location: " . LINK_HOME);
    }

    // Affichage des produits d'une catégorie + pagination
    public function listProducts($categoryId, $page)
    {
        $productManager = new ProductManager();

        $productsPerPage = 8;
        $currentPage = $page;
        $start = ($currentPage - 1) * $productsPerPage;
        $categories = $productManager->getCategories();
        $products = $productManager->getProducts($categoryId, $start, $productsPerPage);
        $numberOfProducts = $productManager->getNumberOfProductsCategory($categoryId);
        $numberOfPages = ceil($numberOfProducts / $productsPerPage);

        require('views/backend/adminProductsView.php');
    }

    // Affichage de tous les produits + pagination
    public function listAllProducts($page)
    {
        $productManager = new ProductManager();

        $productsPerPage = 8;
        $currentPage = $page;
        $start = ($currentPage - 1) * $productsPerPage;
        $categories = $productManager->getCategories();
        $products = $productManager->getAllProducts($start, $productsPerPage);
        $numberOfProducts = $productManager->getNumberOfProducts();
        $numberOfPages = ceil($numberOfProducts / $productsPerPage);

        require('views/backend/adminProductsView.php');
    }

    // Affichage de la page d'ajout d'un produit
    public function newProductView() 
    {
        $productManager = new ProductManager();

        $categories = $productManager->getCategories();

        require('views/backend/adminNewProductView.php');
    }

    // Ajout d'un nouveau produit
    public function addProduct($name, $description, $category)
    {
        $productManager = new ProductManager();

        $name = htmlspecialchars($name);
        $description = htmlspecialchars($description);
        $image = $_FILES['image'];

        if (!empty($name) && !empty($description) && !empty($image) && !empty($category)) {
            $nameLength = strlen($name);
            if($nameLength <= 255) {
                if ($image['size'] <= 2000000) {
                    $fileInfo = pathinfo($image['name']);
                    $extension_upload = $fileInfo['extension'];
                    $authorized_extensions = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
                    if (in_array($extension_upload, $authorized_extensions)) {
                        $insertProduct = $productManager->insertProduct($name, $description, $category);
                        $fileInfo = pathinfo($image['name']);
                        $imageName = 'product_' . $insertProduct . '.' . $fileInfo['extension'];
                        move_uploaded_file($image['tmp_name'], 'public/images/products/' . basename($imageName));
                        $insertImage = $productManager->insertImage($insertProduct, $imageName);
                        if ($insertProduct === false) {
                            throw new \Exception('Impossible d\'ajouter le produit.');
                        }
                        elseif ($insertImage === false) {
                            throw new \Exception('Impossible d\'ajouter l\'image.');
                        }
                        else {
                            header('Location: ' . LINK_ADMIN_PRODUCTS);
                        }
                    }
                    else {
                        $return = 'Extension de l\'image non valide. (Extensions autorisées : .jpg, .jpeg, .gif, .png)';                       
                    }
                }
                else {
                    $return = 'L\'image est trop volumineuse. (Taille maximale : 2 Mo)';                    
                }
            }
            else {
                $return = "Le nom du produit ne doit pas dépasser 255 caractères.";
            }
        }
        else {
            $return = 'Tous les champs ne sont pas remplis.';
        }

        require('views/backend/adminNewProductView.php');
    }

    // Affichage de la page d'édition d'un produit
    public function editProductView($productId) 
    {
        $productManager = new ProductManager();

        $product = $productManager->getProduct($productId);
        $categories = $productManager->getCategories();

        require('views/backend/adminEditProductView.php');
    }

    // Edition d'un produit
    public function editProduct($productId) 
    {
        $productManager = new ProductManager();

        $name = htmlspecialchars($_POST['name']);
        $description = htmlspecialchars($_POST['description']);
        $image = $_FILES['image'];
        $category = $_POST['category'];

        if (!empty($name) && !empty($description)) {
            $nameLength = strlen($name);
            if($nameLength <= 255) {
                if ($image['name']) {
                    if ($image['size'] <= 2000000) {
                        $fileInfo = pathinfo($image['name']);
                        $extension_upload = $fileInfo['extension'];
                        $authorized_extensions = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
                        if (in_array($extension_upload, $authorized_extensions)) {
                            $editProduct = $productManager->setEditProduct($productId, $name, $description, $category);
                            $fileInfo = pathinfo($image['name']);
                            $imageName = 'product_' . $productId . '.' . $fileInfo['extension'];
                            move_uploaded_file($image['tmp_name'], 'public/images/products/' . basename($imageName));
                            $insertImage = $productManager->insertImage($productId, $imageName);
                            if ($editProduct === false) {
                                throw new \Exception('Impossible de modifier le chapitre.');
                            }
                            elseif ($insertImage === false) {
                                throw new \Exception('Impossible de modifier l\'image.');
                            }
                            else {
                               header('Location: ' . LINK_ADMIN_PRODUCTS);
                            }   
                        }
                        else {
                            $return = 'Extension de l\'image non valide. (Extensions autorisées : .jpg, .jpeg, .gif, .png)';                       
                        }
                    }
                    else {
                        $return = 'L\'image est trop volumineuse. (Taille maximale : 2 Mo)';                    
                    }
                }
                else {
                    $editProduct = $productManager->setEditProduct($productId, $name, $description, $category);
                    if ($editProduct === false) {
                        throw new \Exception('Impossible de modifier le produit.');
                    }
                    else {
                       header('Location: ' . LINK_ADMIN_PRODUCTS);
                    }  
                }
            }
            else {
                $return = "Le nom du produit ne doit pas dépasser 255 caractères.";
            }
        }
        else {
            $return = "Tous les champs ne sont pas remplis.";   
        }
        
        $product = $productManager->getProduct($_GET['id']);
        require('views/backend/adminEditProductView.php');  
    }

    // Suppression d'un produit
    public function deleteProduct($productId)
    {
        $productManager = new ProductManager();

        $product = $productManager->getProduct($productId);
        unlink('public/images/products/' . $product->imageName());
        $deleteProduct = $productManager->deleteProduct($productId);

        if ($deleteProduct === false) {
            throw new \Exception('Impossible de supprimer ce produit.');
        }
        else {
            header('Location: ' . LINK_ADMIN_PRODUCTS);
        }    
    }

    // Affichage de la liste de tous les articles + pagination
    public function listPosts($page)
    {
        $postManager = new PostManager();

        $postsPerPage = 8;
        $currentPage = $page;
        $start = ($currentPage - 1) * $postsPerPage;
        $posts = $postManager->getAllPosts($start, $postsPerPage);
        $numberOfPosts = $postManager->getNumberOfPosts();
        $numberOfPages = ceil($numberOfPosts / $postsPerPage);

        require('views/backend/adminPostsView.php');
    }

    // Ajout d'un nouvel article
    public function addPost($title, $content)
    {
        $postManager = new PostManager();

        $title = htmlspecialchars($title);
        $content = htmlspecialchars($content);
        $image = $_FILES['image'];

        if (!empty($title) && !empty($content) && !empty($image)) {
            $titleLength = strlen($title);
            if($titleLength <= 255) {
                if ($image['size'] <= 2000000) {
                    $fileInfo = pathinfo($image['name']);
                    $extension_upload = $fileInfo['extension'];
                    $authorized_extensions = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
                    if (in_array($extension_upload, $authorized_extensions)) {
                        $insertPost = $postManager->insertPost($title, $content);
                        $fileInfo = pathinfo($image['name']);
                        $imageName = 'post_' . $insertPost . '.' . $fileInfo['extension'];
                        move_uploaded_file($image['tmp_name'], 'public/images/posts/' . basename($imageName));
                        $insertImage = $postManager->insertImage($insertPost, $imageName);
                        if ($insertPost === false) {
                            throw new \Exception('Impossible d\'ajouter l\'article.');
                        }
                        elseif ($insertImage === false) {
                            throw new \Exception('Impossible d\'ajouter l\'image.');
                        }
                        else {
                            header('Location: ' . LINK_ADMIN_POSTS);
                        }
                    }
                    else {
                        $return = 'Extension de l\'image non valide. (Extensions autorisées : .jpg, .jpeg, .gif, .png)';                       
                    }
                }
                else {
                    $return = 'L\'image est trop volumineuse. (Taille maximale : 2 Mo)';                    
                }
            }
            else {
                $return = "Le titre ne doit pas dépasser 255 caractères.";
            }
        }
        else {
            $return = 'Tous les champs ne sont pas remplis.';
        }

        require('views/backend/adminNewPostView.php');
    }

    // Affichage de la page d'édition d'un article
    public function editPostView($postId) 
    {
        $postManager = new PostManager();

        $post = $postManager->getPost($postId);

        require('views/backend/adminEditPostView.php');
    }

    // Edition d'un article
    public function editPost($postId) 
    {
        $postManager = new PostManager();

        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);
        $image = $_FILES['image'];

        if (!empty($title) && !empty($content)) {
            $titleLength = strlen($title);
            if($titleLength <= 255) {
                if ($image['name']) {
                    if ($image['size'] <= 2000000) {
                        $fileInfo = pathinfo($image['name']);
                        $extension_upload = $fileInfo['extension'];
                        $authorized_extensions = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
                        if (in_array($extension_upload, $authorized_extensions)) {
                            $editPost = $postManager->setEditPost($postId, $title, $content);
                            $fileInfo = pathinfo($image['name']);
                            $imageName = 'post_' . $postId . '.' . $fileInfo['extension'];
                            move_uploaded_file($image['tmp_name'], 'public/images/posts/' . basename($imageName));
                            $insertImage = $postManager->insertImage($postId, $imageName);
                            if ($editPost === false) {
                                throw new Exception('Impossible de modifier l\'article.');
                            }
                            elseif ($insertImage === false) {
                                throw new Exception('Impossible de modifier l\'image.');
                            }
                            else {
                               header('Location: ' . LINK_ADMIN_POSTS);
                            }   
                        }
                        else {
                            $return = 'Extension de l\'image non valide. (Extensions autorisées : .jpg, .jpeg, .gif, .png)';                       
                        }
                    }
                    else {
                        $return = 'L\'image est trop volumineuse. (Taille maximale : 2 Mo)';                    
                    }
                }
                else {
                    $editPost = $postManager->setEditPost($postId, $title, $content);
                    if ($editPost === false) {
                        throw new Exception('Impossible de modifier le chapitre.');
                    }
                    else {
                       header('Location: ' . LINK_ADMIN_POSTS);
                    }  
                }
            }
            else {
                $return = "Le titre ne doit pas dépasser 255 caractères.";
            }
        }
        else {
            $return = "Tous les champs ne sont pas remplis.";   
        }
        
        $post = $postManager->getPost($_GET['id']);
        require('views/backend/adminEditPostView.php');  
    }

    // Suppression d'un article
    public function deletePost($postId)
    {
        $postManager = new PostManager();

        $post = $postManager->getPost($postId);
        unlink('public/images/posts/' . $post->imageName());
        $deletePost = $postManager->deletePost($postId);

        if ($deletePost === false) {
            throw new \Exception('Impossible de supprimer cet article.');
        }
        else {
            header('Location: ' . LINK_ADMIN_POSTS);
        }    
    }

    // Rendre un article public
    public function onlinePost($postId) 
    {
        $postManager = new PostManager();
        $onlinePost = $postManager->setOnlinePost($postId);

        if ($onlinePost === false) {
            throw new \Exception('Impossible de publier ce chapitre.');
        }
        else {
           header('Location: ' . $_SERVER['HTTP_REFERER']);
        }    
    }

    // Rendre un article privé
    public function offlinePost($postId) 
    {
        $postManager = new PostManager();
        $offlinePost = $postManager->setOfflinePost($postId);

        if ($offlinePost === false) {
            throw new \Exception('Impossible de passer ce chapitre dans les brouillons.');
        }
        else {
           header('Location: ' . $_SERVER['HTTP_REFERER']);
        }    
    }

    // Affichage de la liste de tous les commentaires + pagination
    public function listComments($page)
    {
        $commentManager = new CommentManager();

        $commentsPerPage = 15;
        $currentPage = $page;
        $start = ($currentPage - 1) * $commentsPerPage;
        $comments = $commentManager->getAllComments($start, $commentsPerPage);
        $numberOfComments = $commentManager->getNumberOfComments();
        $numberOfPages = ceil($numberOfComments / $commentsPerPage);

        require('views/backend/adminCommentsView.php');
    }

    // Suppression d'un commentaire
    public function deleteComment($commentId)
    {
        $commentManager = new CommentManager();
        $deleteComment = $commentManager->deleteComment($commentId);

        if ($deleteComment === false) {
            throw new \Exception('Impossible de supprimer ce commentaire.');
        }
        else {
           header('Location: ' . LINK_ADMIN_COMMENTS);
        }    
    }

    // Approbation d'un commentaire signalé
    public function deleteCommentReport($commentId)
    {
        $commentManager = new CommentManager();
        $deleteReport = $commentManager->setDeleteReporting($commentId);

        if ($deleteReport === false) {
            throw new \Exception('Impossible de supprimer le signalement.');
        }
        else {
            header('Location: ' . LINK_ADMIN_COMMENTS);
        }
    }

    // Affichage de la liste des points de ventes
    public function listShops()
    {
        $shopManager = new ShopManager();
        $shops = $shopManager->getShops();

        require('views/backend/adminShopsView.php');
    }

    // Ajout d'un point de vente
    public function addShop($name, $adress, $city, $postal, $latitude, $longitude)
    {
        $shopManager = new ShopManager();

        $name = htmlspecialchars($name);
        $adress = htmlspecialchars($adress);
        $city = htmlspecialchars($city);
        $postal = htmlspecialchars($postal);
        $latitude = htmlspecialchars($latitude);
        $longitude = htmlspecialchars($longitude);

        if (!empty($name) && !empty($adress) && !empty($city) && !empty($postal) && !empty($latitude) && !empty($longitude)) {
            $nameLength = strlen($name);
            $adressLength = strlen($adress);
            $insertShop = $shopManager->insertShop($name, $adress, $city, $postal, $latitude, $longitude);
            if ($insertShop === false) {
                throw new \Exception('Impossible d\'ajouter le point de vente.');
            }
            else {
                header('Location: ' . LINK_ADMIN_SHOPS);
            }
        }
        else {
            $return = "Tous les champs ne sont pas remplis.";
        }
    }

    // Suppression d'un point de vente
    public function deleteShop($shopId)
    {
        $shopManager = new ShopManager();
        $deleteShop = $shopManager->deleteShop($shopId);

        if ($deleteShop === false) {
            throw new \Exception('Impossible de supprimer ce point de vente.');
        }
        else {
           header('Location: ' . LINK_ADMIN_SHOPS);
        }    
    }

    // Affichage de la page d'édition de la page d'accueil
    public function editHomeView() 
    {
        $contentManager = new ContentManager();

        $flag = "home";
        $data = $contentManager->getContent($flag);

        require('views/backend/adminEditHomeView.php');  
    }

    // Edition de la page d'accueil
    public function editHome() 
    {
        $contentManager = new ContentManager();

        $flag = "home";
        $banner = $_FILES['banner'];
        $text = htmlspecialchars($_POST['text']);

        if (!empty($text)) {
            if ($banner['name']) {
                if ($banner['size'] <= 2000000) {
                    $fileInfo = pathinfo($banner['name']);
                    $extension_upload = $fileInfo['extension'];
                    $authorized_extensions = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
                    if (in_array($extension_upload, $authorized_extensions)) {
                        $editHome = $contentManager->setEditTextOne($flag, $text);
                        $fileInfo = pathinfo($banner['name']);
                        $imageName = 'home_banner' . '.' . $fileInfo['extension'];
                        move_uploaded_file($banner['tmp_name'], 'public/images/contents/' . basename($imageName));
                        $editBanner = $contentManager->setEditBanner($flag, $imageName);
                        if ($editHome === false) {
                            throw new \Exception('Impossible de modifier le texte de bienvenue.');
                        }
                        elseif ($editBanner === false) {
                            throw new \Exception('Impossible de modifier la bannière.');
                        }
                        else {
                           header('Location: ' . LINK_HOME);
                        }   
                    }
                    else {
                        $return = 'Extension de l\'image non valide. (Extensions autorisées : .jpg, .jpeg, .gif, .png)';                       
                    }
                }
                else {
                    $return = 'L\'image est trop volumineuse. (Taille maximale : 2 Mo)';                    
                }
            }
            else {
                $editHome = $contentManager->setEditTextOne($flag, $text);
                if ($editHome === false) {
                    throw new \Exception('Impossible de modifier le texte de bienvenue.');
                }
                else {
                   header('Location: ' . LINK_HOME);
                }  
            }
        }
        else {
            $return = "Erreur : Le texte d'accueil est vide.";   
        }
        
        $data = $contentManager->getContent($flag);
        require('views/backend/adminEditHomeView.php');  
    }

    // Affichage de la page d'édition de la page "A propos"
    public function editAboutView() 
    {
        $contentManager = new ContentManager();

        $flag = "about";
        $data = $contentManager->getContent($flag);

        require('views/backend/adminEditAboutView.php');  
    }

    // Edition de la page "A propos"
    public function editAbout() 
    {
        $contentManager = new ContentManager();

        $flag = "about";
        $image_1 = $_FILES['image_1'];
        $image_2 = $_FILES['image_2'];
        $text_1 = htmlspecialchars($_POST['text_1']);
        $text_2 = htmlspecialchars($_POST['text_2']);

        if (!empty($text_1 AND !empty($text_2))) {
            if (!empty($image_1)) {
                if ($image_1['size'] <= 2000000) {
                    $fileInfo = pathinfo($image_1['name']);
                    $extension_upload = $fileInfo['extension'];
                    $authorized_extensions = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
                    if (in_array($extension_upload, $authorized_extensions)) {
                        $fileInfo = pathinfo($image_1['name']);
                        $imageName = 'about_image_1' . '.' . $fileInfo['extension'];
                        move_uploaded_file($image_1['tmp_name'], 'public/images/contents/' . basename($imageName));
                        $editImage = $contentManager->setEditImageOne($flag, $imageName);
                        if ($editImage === false) {
                            throw new \Exception('Impossible de modifier l\'image.');
                        }
                    }
                    else {
                        $return = 'Extension de l\'image non valide. (Extensions autorisées : .jpg, .jpeg, .gif, .png)';                       
                    }
                }
                else {
                    $return = 'L\'image est trop volumineuse. (Taille maximale : 2 Mo)';                    
                }
            }
            if (!empty($image_2)) {
                if ($image_2['size'] <= 2000000) {
                    $fileInfo = pathinfo($image_2['name']);
                    $extension_upload = $fileInfo['extension'];
                    $authorized_extensions = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
                    if (in_array($extension_upload, $authorized_extensions)) {
                        $fileInfo = pathinfo($image_2['name']);
                        $imageName = 'about_image_2' . '.' . $fileInfo['extension'];
                        move_uploaded_file($image_2['tmp_name'], 'public/images/contents/' . basename($imageName));
                        $editImage = $contentManager->setEditImageTwo($flag, $imageName);
                        if ($editImage === false) {
                            throw new \Exception('Impossible de modifier l\'image.');
                        }
                    }
                    else {
                        $return = 'Extension de l\'image non valide. (Extensions autorisées : .jpg, .jpeg, .gif, .png)';                       
                    }
                }
                else {
                    $return = 'L\'image est trop volumineuse. (Taille maximale : 2 Mo)';                    
                }
            }
            $editAbout = $contentManager->setEditTextOne($flag, $text_1);
            if ($editAbout === false) {
                throw new \Exception('Impossible de modifier le texte.');
            }
            $editAbout = $contentManager->setEditTextTwo($flag, $text_2);
            if ($editAbout === false) {
                throw new \Exception('Impossible de modifier le texte.');
            }
            else {
                header('Location: ' . LINK_ABOUT);
            }
        }
        else {
            $return = "Erreur : Un des textes est vide.";   
        }
        
        $data = $contentManager->getContent($flag);
        require('views/backend/adminEditAboutView.php');  
    }
}