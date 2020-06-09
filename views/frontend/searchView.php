<?php
$title = "Recherche";
$meta_description = "";
$meta_url = "www.projet5.n-romano.fr/recherche";
?>

<?php ob_start(); ?>

<h1 class="title">Recherche</h1>

<section id="search_results">
	<?php if(count($posts) OR count($products)) { ?>
		<?php
		if(count($posts)) { echo "<h2>Articles</h2>"; }
	    foreach ($posts as $post) {
	    ?>
	        <div id="postpreview">
	            <div><?php if (!empty($post->imageName())) { ?><img src="public/images/posts/<?= $post->imageName() ?>" alt="Image de l'article" /><?php } ?></div>
	            <div>
	                <h3>
	                    <?= htmlspecialchars_decode($post->title()) ?><br />
	                    <span class="date">le <?= $post->creationDate() ?></span>
	                </h3>
	                    
	                <p>
	                    <?php
	                    $postDescription = nl2br(strip_tags(htmlspecialchars_decode($post->content())));
	                    echo substr($postDescription, 0, 300) . '...';
	                    ?>
	                </p>
	                <p><a class="bold" href="<?= LINK_POST . transform_into_url(utf8_encode($post->title())) . '-' . $post->id() ?>">Lire l'article</a></p>
	            </div>
	        </div>
	    <?php } ?>

	    <?php
		if(count($products)) { echo "<h2>Produits</h2>"; }
		echo '<div id="products">';
	    foreach ($products as $product) {
	    ?>
	        <div class="product">
	            <h3><?= $product->name() ?></h3>
	            <img src="public/images/products/<?= $product->imageName() ?>" alt="Photo du produit" />
	            <p><?= htmlspecialchars_decode($product->description()) ?></p>
	        </div>
	    <?php } ?>
		</div>
	<?php } else { echo '<p>Aucun résultat pour votre recherche : <em>' . $search . '</em>.'; } ?>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>