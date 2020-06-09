<?php
session_start();
require_once('include/functions.php');
require_once('include/links.php');

spl_autoload_register(function ($class)
{
    $class = str_replace('Nicolas\FermeHaffner\Controllers\\', '', $class);
    $class = str_replace('Nicolas\FermeHaffner\Models\\', '', $class);
    $files = array('controllers/' . $class . '.php', 'models/' . $class . '.php');

    foreach ($files as $file)
    {
        if (file_exists($file))
        {
            require_once $file;
        }
    }
});

$frontend = new Nicolas\FermeHaffner\Controllers\FrontendController();
$backend = new Nicolas\FermeHaffner\Controllers\BackendController();

try {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'home':
                $frontend->home();
            break;

            case 'search':
                if (isset($_POST['search'])) {
                    $frontend->search();
                }
                else {
                    $frontend->home();
                }
            break;

            case 'connect':
                if (!isset($_SESSION['login']) OR !isset($_COOKIE['login'])) {
                    $backend->connect();
                }
                else {
                    $frontend->home();
                }
            break;

            case 'disconnect':
                $backend->disconnect();
            break;

            case 'label':
                require('views/frontend/labelView.php');
            break;

            case 'listProducts':
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    if (isset($_GET['page']) AND !empty($_GET['page'])) {
                        $frontend->listProducts(intval($_GET['page']));
                    }
                    else {
                        $frontend->listProducts(1);
                    }
                }
                else {
                    $frontend->lastProducts();
                }
            break;

            case 'shops':
                $frontend->listShops();
            break;

            case 'listPosts':
            if (isset($_GET['page']) AND !empty($_GET['page'])) {
                $frontend->listPosts(intval($_GET['page']));
            }
            else {
                $frontend->listPosts(1);
            }
            break;

            case 'post':
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    if (isset($_GET['page']) AND !empty($_GET['page'])) {
                        $frontend->post(intval($_GET['page']));
                    }
                    else {
                        $frontend->post(1);
                    }
                }
                else {
                    $frontend->listPosts(1);
                }
            break;

            case 'addComment':
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    if (isset($_POST['author'])) {
                        if (isset($_GET['page']) AND !empty($_GET['page'])) {
                            $frontend->addComment($_GET['id'], $_POST['author'], $_POST['mail'], $_POST['comment'], intval($_GET['page']));
                        }
                        else {
                            $frontend->addComment($_GET['id'], $_POST['author'], $_POST['mail'], $_POST['comment'], 1);
                        }
                    }
                    else {
                        $frontend->post(1);
                    }
                }
                else {
                    $frontend->home();
                }
            break;

            case 'reportComment':
                if (isset($_GET['post_id']) && $_GET['post_id'] > 0) {
                    if(isset($_GET['comment_id']) && $_GET['comment_id'] > 0) {
                        $frontend->reportComment($_GET['comment_id'], $_GET['post_id']);
                    }
                    else {
                        $frontend->home();
                    }
                }
                else {
                    $frontend->home();
                }
            break;

            case 'about':
                $frontend->about();
            break;

            case 'contact':
                require('views/frontend/contactView.php');
            break;

            case 'sendMail':
                if (isset($_POST['author'])) {
                    $frontend->sendMail($_POST['author'], $_POST['mail'], $_POST['subject'], $_POST['content']);
                }
                else {
                    require('views/frontend/contactView.php');
                }
            break;


            case 'admin':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    require('views/backend/adminView.php');
                }
                else {
                    require('views/frontend/connectView.php');
                }
            break;

            case 'adminProducts':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    if((isset($_POST['product_category']) AND ($_POST['product_category'] > 0)) OR ((isset($_GET['id']) AND !empty($_GET['id'])))) {
                        if (isset($_GET['page']) AND !empty($_GET['page'])) {
                            $backend->listProducts($_GET['id'], intval($_GET['page']));
                        }
                        else {
                            $backend->listProducts($_POST['product_category'], 1);
                        }
                    }
                    else {
                        if (isset($_GET['page']) AND !empty($_GET['page'])) {
                            $backend->listAllProducts(intval($_GET['page']));
                        }
                        else {
                            $backend->listAllProducts(1);
                        }
                    }
                }
                else {
                    require('views/frontend/connectView.php');
                }
            break;

            case 'adminNewProduct':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    $backend->newProductView();
                }
                else {
                    require('views/frontend/connectView.php'); 
                }
            break;

            case 'addProduct':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    if (isset($_POST['name'])) {
                        $backend->addProduct($_POST['name'], $_POST['description'], $_POST['category']);
                    }
                    else {
                        require('views/backend/adminNewProductView.php');
                    }
                }
                else {
                    require('views/frontend/connectView.php'); 
                }
            break;

            case 'adminEditProduct':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $backend->editProductView($_GET['id']);
                    }
                    else {
                        throw new \Exception('Aucun identifiant envoyé.');
                    }
                }
                else {
                    require('views/frontend/connectView.php'); 
                }
            break;

            case 'editProduct':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        if (isset($_POST['name'])) {
                            $backend->editProduct($_GET['id']);
                        }
                        else {
                            $backend->editProductView($_GET['id']);
                        }
                    }
                    else {
                        throw new \Exception('Aucun identifiant envoyé.');
                    }
                }
                else {
                    require('views/frontend/connectView.php'); 
                }
            break;

            case 'deleteProduct':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $backend->deleteProduct($_GET['id']);
                    }
                    else {
                        throw new \Exception('Aucun identifiant envoyé.');
                    }
                }
                else {
                    require('views/frontend/connectView.php'); 
                }
            break;

            case 'adminPosts':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    if (isset($_GET['page']) AND !empty($_GET['page'])) {
                        $backend->listPosts(intval($_GET['page']));
                    }
                    else {
                        $backend->listPosts(1);
                    }
                }
                else {
                    require('views/frontend/connectView.php');
                }
            break;

            case 'adminNewPost':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    require('views/backend/adminNewPostView.php');
                }
                else {
                    require('views/frontend/connectView.php'); 
                }
            break;

            case 'addPost':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    if (isset($_POST['title'])) {
                        $backend->addPost($_POST['title'], $_POST['content']);
                    }
                    else {
                        require('views/backend/adminNewPostView.php');
                    }
                }
                else {
                    require('views/frontend/connectView.php'); 
                }
            break;

            case 'adminEditPost':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $backend->editPostView($_GET['id']);
                    }
                    else {
                        throw new \Exception('Aucun identifiant de billet envoyé');
                    }
                }
                else {
                    require('views/frontend/connectView.php'); 
                }
            break;

            case 'editPost':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        if (isset($_POST['title'])) {
                            $backend->editPost($_GET['id']);
                        }
                        else {
                            $backend->editPostView($_GET['id']);
                        }
                    }
                    else {
                        throw new \Exception('Aucun identifiant envoyé.');
                    }
                }
                else {
                    require('views/frontend/connectView.php'); 
                }
            break;

            case 'deletePost':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $backend->deletePost($_GET['id']);
                    }
                    else {
                        throw new \Exception('Aucun identifiant de billet envoyé');
                    }
                }
                else {
                    require('views/frontend/connectView.php'); 
                }
            break;

            case 'onlinePost':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $backend->onlinePost($_GET['id']);
                    }
                    else {
                        throw new \Exception('Aucun identifiant de billet envoyé');
                    }
                }
                else {
                    require('views/frontend/connectView.php'); 
                }
            break;

            case 'offlinePost':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $backend->offlinePost($_GET['id']);
                    }
                    else {
                        throw new \Exception('Aucun identifiant de billet envoyé');
                    }
                }
                else {
                    require('views/frontend/connectView.php'); 
                }
            break;

            case 'adminComments':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    if (isset($_GET['page']) AND !empty($_GET['page'])) {
                        $backend->listComments(intval($_GET['page']));
                    }
                    else {
                        $backend->listComments(1);
                    }
                }
                else {
                    require('views/frontend/connectView.php');
                }
            break;

            case 'deleteComment':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $backend->deleteComment($_GET['id']);
                    }
                    else {
                        throw new \Exception('Aucun identifiant de commentaire envoyé');
                    }
                }
                else {
                    require('views/frontend/connectView.php'); 
                }
            break;

            case 'deleteCommentReport':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $backend->deleteCommentReport($_GET['id']);
                    }
                    else {
                        throw new \Exception('Aucun identifiant de commentaire envoyé');
                    }
                }
                else {
                    require('views/frontend/connectView.php'); 
                }
            break;

            case 'adminShops':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    $backend->listShops();
                }
                else {
                    require('views/frontend/connectView.php');
                }
            break;

            case 'addShop':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    if (isset($_POST['name'])) {
                        $backend->addShop($_POST['name'], $_POST['adress'], $_POST['city'], $_POST['postal'], $_POST['latitude'], $_POST['longitude']);
                    }
                    else {
                        require('views/backend/adminShopsView.php');
                    }
                }
                else {
                    require('views/frontend/connectView.php');
                }
            break;

            case 'deleteShop':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $backend->deleteShop($_GET['id']);
                    }
                    else {
                        throw new \Exception('Aucun identifiant envoyé.');
                    }
                }
                else {
                    require('views/frontend/connectView.php'); 
                }
            break;

            case 'adminEditHome':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    $backend->editHomeView();
                }
                else {
                    require('views/frontend/connectView.php');
                }
            break;

            case 'editHome':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    $backend->editHome();
                }
                else {
                    require('views/frontend/connectView.php');
                }
            break;

            case 'adminEditAbout':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    $backend->editAboutView();
                }
                else {
                    require('views/frontend/connectView.php');
                }
            break;

            case 'editAbout':
                if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) {
                    $backend->editAbout();
                }
                else {
                    require('views/frontend/connectView.php');
                }
            break;

            case 'legalNotice':
                require('views/frontend/legalNotice.php');
            break;

            default:
                $frontend->home();
            break;
        }
    }
    else {
    	$frontend->home();
    }
}

catch(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}