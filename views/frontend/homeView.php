<?php
$title = "Fumé Lorrain";
$meta_description = "La ferme Haffner vous propose un savoir-faire dans la tradition : Porcs nés, élevés, nourris avec nos céréales garanties sans OGM, et transformés à la ferme, avec une vraie traçabilité et la passion du goût pour une table réussie...";
$meta_url = "www.projet5.n-romano.fr";
?>

<?php ob_start(); ?>

<img class="banner" src="public/images/contents/<?= $data->banner() ?>" alt="Bannière" />

<section id="home">
    <h1><?= nl2br(htmlspecialchars_decode($data->textOne())) ?></h1>
</section>

<h2 class="title margin">Nos produits</h2>
<section id="home_products">
	<?php
	$productExist = count($products);
    if($productExist) {
        foreach ($products as $product)
        {
        ?>
            <div class="home_product">
                <h3><?= htmlspecialchars_decode($product->name()) ?></h3>
                <div><?php if (!empty($product->imageName())) { ?><img src="public/images/products/<?= $product->imageName() ?>" alt="Photo du produit" /><?php } ?></div>
                <p class="home_product_description"><?= nl2br(strip_tags(htmlspecialchars_decode($product->description()))); ?></p>
            </div>
        <?php
        }
        ?>
        <div class="home_product"><a class="bold" href="<?= LINK_PRODUCTS ?>">Voir la liste complète de nos produits</a></div>
    <?php
    } else { 
        echo "<p><em>Pas de produit disponible.</em></p>";
    } ?>
</section>

<h2 class="title">Derniers articles</h2>
<section id="home_blog">
	<?php
	$postExist = count($posts);
	if($postExist) {
		foreach ($posts as $post)
		{
		?>
			<div class="home_postpreview">
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
		<?php
		}
		?>
	<p class="center"><a class="button" href="<?= LINK_BLOG ?>">Voir les autres articles</a></p>
	<?php
	} else { 
	    echo '<p class="center"><em>Pas d\'article disponible.</em></p>';
	} ?>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>