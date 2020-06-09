<?php
$title = "Nos produits";
$meta_description = "Découvrez notre gamme de produits du terroir lorrain : les terrines, les charcuteries, viandes fraîches et fumées... dans le pur style des saveurs d'antan.";
$meta_url = "www.projet5.n-romano.fr/produits";
?>

<?php ob_start(); ?>

<h1 class="title">Nos produits</h1>

<section id="listproducts">
    <div class="product_categories">
        <?php if (isset($_GET['id'])) { ?>
            <a href="<?= LINK_PRODUCTS ?>">Nouveautés</a>
        <?php } else { echo '<strong>Nouveautés</strong>'; }
        while ($category = $categories->fetch()) {
            if (isset($_GET['id']) && $category['id'] == $_GET['id']) {
                echo '<strong>' . utf8_decode($category['name']) . '</strong>';
            }
            else { ?>
                <a href="<?= LINK_PRODUCTS . '-' . transform_into_url($category['name']) . '-' . $category['id'] ?>"><?= utf8_decode($category['name']) ?></a>
        <?php
            }  
        }
        $categories->closeCursor();
        ?>
    </div>

    <?php
    $productExist = count($products);
    if($productExist) {
        echo '<div id="products">';
        foreach ($products as $product) { ?>
            <div class="product">
                <h3><?= $product->name() ?></h3>
                <img src="public/images/products/<?= $product->imageName() ?>" alt="Photo du produit" />
                <p><?= htmlspecialchars_decode($product->description()) ?></p>
            </div>
        <?php }
        echo '</div>';
        if (isset($_GET['id'])) {
            if($numberOfPages > 1) {
                echo "<p class='center'>Pages : ";
                for ($i = 1; $i <= $numberOfPages; $i++) {
                    $link = '<a href="' . LINK_PRODUCTS . '-' . transform_into_url($data['name']) . '-' . $_GET['id'] . '-' . $i . '">' . $i . ' </a>' ;
                    pagination($link, $numberOfPages, $currentPage, $i);
                }
                echo "</p>";
            }
        }

    } else { 
        echo "<p><em>Pas de produit disponible.</em></p>";
    } ?>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>