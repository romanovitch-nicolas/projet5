<?php
require_once('include/functions.php');
require_once("models/PostManager.php");
require_once("models/ProductManager.php");

$postManager = new \Nicolas\FermeHaffner\Models\PostManager();
$productManager = new \Nicolas\FermeHaffner\Models\ProductManager();
$posts = $postManager->getOnlinePosts(0, 10000);
$productsCategories = $productManager->getCategories();

header("Content-Type: text/xml;charset=utf-8");
echo '<?xml version="1.0" encoding="utf-8"?>';
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> 
	<url>
		<loc>www.projet5.n-romano.fr</loc>
	</url>
	<url>
		<loc>www.projet5.n-romano.fr/bleu-blanc-coeur</loc>
	</url>
	<url>
		<loc>www.projet5.n-romano.fr/produits</loc>
	</url>
	<url>
		<loc>www.projet5.n-romano.fr/points-de-vente</loc>
	</url>
	<url>
		<loc>www.projet5.n-romano.fr/blog</loc>
	</url>
	<url>
		<loc>www.projet5.n-romano.fr/about</loc>
	</url>
	<url>
		<loc>www.projet5.n-romano.fr/contact</loc>
	</url>

	<?php
	$postExist = $posts->rowCount();
	if($postExist) {
		while ($post = $posts->fetch()) { ?>
			<url>
				<loc>www.projet5.n-romano.fr/blog-<?= transform_into_url(utf8_encode($post['title'])) . '-' . $post['id'] ?></loc>
			</url>
		<?php
		}
	}
	?>

	<?php
	while ($category = $productsCategories->fetch()) { ?>
		<url>
			<loc>www.projet5.n-romano.fr/produits-<?= transform_into_url($category['name']) . '-' . $category['id'] ?></loc>
		</url>
	<?php
	}
	?>
</urlset>