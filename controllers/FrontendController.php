<?php
namespace Nicolas\FermeHaffner\Controllers;

use \Nicolas\FermeHaffner\Models\CommentManager;
use \Nicolas\FermeHaffner\Models\ContentManager;
use \Nicolas\FermeHaffner\Models\PostManager;
use \Nicolas\FermeHaffner\Models\ProductManager;
use \Nicolas\FermeHaffner\Models\ShopManager;


class FrontendController
{
    // Affichage du contenu de la page d'accueil
    public function home()
    {
        $contentManager = new ContentManager();
        $postManager = new PostManager();
        $productManager = new ProductManager();

        $flag = "home";
        $data = $contentManager->getContent($flag);
        $posts = $postManager->getLastPosts();
        $products = $productManager->getRandomProducts();

        require('views/frontend/homeView.php');
    }

    // Recherche
    public function search()
    {
        $postManager = new PostManager();
        $productManager = new ProductManager();

        $search = htmlspecialchars($_POST['search']);
        $searchArray = explode(' ', $search);
        foreach ($searchArray as $value) {
            $posts = $postManager->searchPosts($value);
            $products = $productManager->searchProducts($value);
        }

        require('views/frontend/searchView.php');
    }

    // Affichage des produits d'une catégorie + pagination
    public function listProducts($page)
    {
        $productManager = new ProductManager();

        $productsPerPage = 8;
        $currentPage = $page;
        $start = ($currentPage - 1) * $productsPerPage;
        $data = $productManager->getCategory($_GET['id']);
        $categories = $productManager->getCategories();
        $products = $productManager->getProducts($_GET['id'], $start, $productsPerPage);
        $numberOfProducts = $productManager->getNumberOfProductsCategory($_GET['id']);
        $numberOfPages = ceil($numberOfProducts / $productsPerPage);

        require('views/frontend/listProductsView.php');
    }

    // Affichage des 5 derniers produits
    public function lastProducts()
    {
        $productManager = new ProductManager();

        $categories = $productManager->getCategories();
        $products = $productManager->getLastProducts();

        require('views/frontend/listProductsView.php');
    }

    // Affichage de la liste des points de ventes
    public function listShops()
    {
        $shopManager = new ShopManager();

        $shops = $shopManager->getShops();

        require('views/frontend/shopsView.php');
    }

    // Affichage des chapitres publiés + pagination
    public function listPosts($page)
    {
        $postManager = new PostManager();

        $postsPerPage = 5;
        $currentPage = $page;
        $start = ($currentPage - 1) * $postsPerPage;
        $posts = $postManager->getOnlinePosts($start, $postsPerPage);
        $numberOfPosts = $postManager->getNumberOfOnlinePosts();
        $numberOfPages = ceil($numberOfPosts / $postsPerPage);

        require('views/frontend/listPostsView.php');
    }

    // Affichage d'un chapitre + pagination des commentaires
    public function post($page)
    {
        $postManager = new PostManager();
        $commentManager = new CommentManager();

        $post = $postManager->getPost($_GET['id']);
        $commentsPerPage = 8;
        $currentPage = $page;
        $start = ($currentPage - 1) * $commentsPerPage;
        $comments = $commentManager->getComments($_GET['id'], $start, $commentsPerPage);
        $numberOfComments = $commentManager->getNumberOfCommentsPost($_GET['id']);
        $numberOfPages = ceil($numberOfComments / $commentsPerPage);

        require('views/frontend/postView.php');
    }

    // Ajout d'un commentaire
    public function addComment($postId, $author, $mail, $comment, $page)
    {
        $postManager = new PostManager();
        $commentManager = new CommentManager();

        $author = htmlspecialchars($author);
        $mail = htmlspecialchars($mail);
        $comment = htmlspecialchars($comment);

        if (!empty($author) && !empty($mail) && !empty($comment)) {
            $nameLength = strlen($author);
            $mailLength = strlen($mail);
            if($nameLength <= 255) {
                if($mailLength <= 255) {
                    if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail)) {
                        $insertComment = $commentManager->insertComment($postId, $author, $mail, $comment);
                        if ($insertComment === false) {
                            throw new \Exception('Impossible d\'ajouter le commentaire.');
                        }
                        else {
                            header('Location: ' . $_SERVER['HTTP_REFERER']);
                        }
                    }
                    else {
                        $return = "Veuillez renseigner une adresse mail valide.";
                    }
                }
                else {
                    $return = "Votre mail ne doit pas dépasser 255 caractères.";
                }
            }
            else {
                $return = "Votre nom ne doit pas dépasser 255 caractères.";
            }
        }
        else {
            $return = "Tous les champs ne sont pas remplis.";
        }

        $commentsPerPage = 8;
        $currentPage = $page;
        $start = ($currentPage - 1) * $commentsPerPage;
        $post = $postManager->getPost($_GET['id']);
        $comments = $commentManager->getComments($_GET['id'], $start, $commentsPerPage);
        $numberOfComments = $commentManager->getNumberOfCommentsPost($_GET['id']);
        $numberOfPages = ceil($numberOfComments / $commentsPerPage);
        require("views/frontend/postView.php");
    }

    // Signalement d'un commentaire
    public function reportComment($commentId, $postId)
    {
        $postManager = new PostManager();
        $commentManager = new CommentManager();

        $post = $postManager->getPost($postId);
        $report = $commentManager->setReporting($commentId);

        if ($report === false) {
            throw new \Exception('Impossible de signaler le commentaire.');
        }
        else {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    // Affichage du contenu de la page "A propos"
    public function about()
    {
        $contentManager = new ContentManager();

        $flag = "about";
        $content = $contentManager->getContent($flag);

        require('views/frontend/aboutView.php');
    }

    // Envoi d'un mail
    public function sendMail($author, $mail, $subject, $content)
    {
        $author = htmlspecialchars($author);
        $mail = htmlspecialchars($mail);
        $subject = htmlspecialchars($subject);
        $content = htmlspecialchars($content);

        if (!empty($author) && !empty($mail) && !empty($subject) && !empty($content)) {
            $nameLength = strlen($author);
            $mailLength = strlen($mail);
            $subjectLength = strlen($subject);
            if($nameLength <= 255) {
                if($mailLength <= 255) {
                    if($subjectLength <= 255) {
                        if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail)) {
                            $header="MIME-Version: 1.0\r\n";
                            $header.='From:"Ferme-Haffner.com"<contact@ferme-haffner.com>'."\n";
                            $header.='Content-Type: text/html; charset="utf-8"'."\n";
                            $header.='Content-Transfer-Encoding: 8bit';
                            $message='
                                <html>
                                    <body>
                                        <p>Vous avez reçu un nouveau message depuis <a href="www.ferme-haffner.com">ferme-haffner.com</a>.</p>
                                        <br />
                                        <p>De : ' . $author . ' (' . $mail . ')</p>
                                        <p>Objet : ' . $subject . '</p>
                                        <p>' . $content . '</p>
                                        <br />
                                        <p><em>Ceci est un mail automatique, merci de ne pas répondre.</em></p>
                                    </body>
                                </html>
                                ';
                            mail("nromanovitch@gmail.com", "Nouveau message !", $message, $header);
                            $return = true;
                        }
                        else {
                            $return = 'Veuillez renseigner une adresse mail valide.';
                        }
                    }
                    else {
                        $return = 'Le sujet ne doit pas dépasser 255 caractères.';
                    }
                }
                else {
                    $return = 'Votre email ne doit pas dépasser 255 caractères.';
                }
            }
            else {
                $return = 'Votre nom ne doit pas dépasser 255 caractères.';
            }
        }
        else {
            $return = 'Tous les champs ne sont pas remplis.';
        }
        require("views/frontend/contactView.php");
    }
}