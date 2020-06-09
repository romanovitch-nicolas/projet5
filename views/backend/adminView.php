<?php
$title = "Administration";
$meta_description = "";
$meta_url = "";
?>

<?php ob_start(); ?>    
    
<h1 class="title">Administration</h1>

<section id="admin">
	<table>
		<tr>
			<td><i class="fas fa-shopping-basket fa-2x"></i></td>
			<td><a href="<?= LINK_ADMIN_PRODUCTS ?>">Gérer les produits</a></td>
		</tr>
		<tr>
			<td><i class="fas fa-book-open fa-2x"></i></td>
			<td><a href="<?= LINK_ADMIN_POSTS ?>">Gérer les articles</a></td>
		</tr>
		<tr>
			<td><i class="fas fa-envelope fa-2x"></i></td>
			<td><a href="<?= LINK_ADMIN_COMMENTS ?>">Gérer les commentaires</a></td>
		</tr>
		<tr>
			<td><i class="fas fa-map-marker fa-2x"></i></td>
			<td><a href="<?= LINK_ADMIN_SHOPS ?>">Gérer les points de vente</a></td>
		</tr>
		<tr>
			<td><i class="fas fa-home fa-2x"></i></td>
			<td><a href="<?= LINK_ADMIN_EDIT_HOME ?>">Modifier la page d'accueil</a></td>
		</tr>
		<tr>
			<td><i class="fas fa-tractor fa-2x"></i></td>
			<td><a href="<?= LINK_ADMIN_EDIT_ABOUT ?>">Modifier la page "A propos"</a></td>
		</tr>
	</table>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>