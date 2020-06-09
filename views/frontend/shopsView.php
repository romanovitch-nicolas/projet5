<?php
$title = "Points de Vente";
$meta_description = "Retrouvez la liste des points de vente qui proposent nos produits.";
$meta_url = "www.projet5.n-romano.fr/points-de-vente";
?>

<?php ob_start(); ?>    
    
<h1 class="title">Points de Vente</h1>

<section id="shops">
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras finibus nulla sit amet ligula ultrices, a sollicitudin massa mattis.</p>
	<div id="map"></div>
			<?php
			$shopExist = count($shops);
			if($shopExist) {
				foreach ($shops as $shop) { ?>
					<p><a href="#" class="map-navigation" data-zoom="17" data-position="<?= $shop->latitude() ?>, <?= $shop->longitude() ?>"><strong><?= $shop->name() ?></strong></a> - <?= $shop->adress() ?>, <?= $shop->postalCode() . " " . $shop->city() ?></p>
				<?php }
			} else {
				echo "<p><em>Pas de points de vente.</em></p>";
			}
			?>
</section>

<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<script src="public/js/ajax.js"></script>
<script src="public/js/map.js"></script>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>