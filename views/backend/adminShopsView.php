<?php
$title = "Gérer les points de vente";
$meta_description = "";
$meta_url = "";
?>

<?php ob_start(); ?>    
    
<h1 class="title">Gérer les points de vente</h1>

<section id="adminshops">
	<span class="button">Ajouter un point de vente</span>
	<div>
		<form method="POST" action="index.php?action=addShop">
			<table>
				<tr>
					<td><label for="shopName">Nom</label></td>
					<td><input type="text" id="shopName" name="name" maxlength="255" value ="<?php if (isset($_POST['shopName'])) { echo $_POST['shopName']; } ?>" required /></td>
				</tr>
				<tr>
					<td><label for="shopAdress">Adresse</label></td>
					<td><input type="text" id="shopAdress" name="adress" maxlength="255" value ="<?php if (isset($_POST['shopAdress'])) { echo $_POST['shopAdress']; } ?>" required /></td>
				</tr>
				<tr>
					<td><label for="shopCity">Ville</label></td>
					<td><input type="text" id="shopCity" name="city" maxlength="255" value ="<?php if (isset($_POST['shopCity'])) { echo $_POST['shopCity']; } ?>" required /></td>
				</tr>
				<tr>
					<td><label for="shopPostal">Code Postal</label></td>
					<td><input type="text" id="shopPostal" name="postal" maxlength="255" value ="<?php if (isset($_POST['shopPostal'])) { echo $_POST['shopPostal']; } ?>" required /></td>
				</tr>
				<br />
				<tr>
					<td><label for="shopLatitude">Latitude</label></td>
					<td><input type="text" id="shopLatitude" name="latitude" maxlength="255" value ="<?php if (isset($_POST['shopLatitude'])) { echo $_POST['shopLatitude']; } ?>" required /></td>
				</tr>
				<tr>
					<td><label for="shopLongitude">Longitude</label></td>
					<td><input type="text" id="shopLongitude" name="longitude" maxlength="255" value ="<?php if (isset($_POST['shopLongitude'])) { echo $_POST['shopLongitude']; } ?>" required /></td>
				</tr>
			</table>
			<input class="button" type="submit" name="addShop" value="Ajouter" />
		</form>
	</div>

	<div>
		<?php
		$shopExist = count($shops);
		if($shopExist) {
		?>
		<table>
			<thead>
				<tr>
					<th>Nom</th>
					<th>Adresse</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($shops as $shop)
					{
					?>
						<tr>
							<td><?= $shop->name() ?></td>
							<td><?= $shop->adress() ?>,<br />
								<?= $shop->postalCode() ?> <?= $shop->city() ?></td>
							<td><a href="index.php?action=deleteShop&amp;id=<?= $shop->id() ?>" onclick="if(confirm('Supprimer définitivement ?')){return true;}else{return false;}" title="Supprimer"><i class="fas fa-trash"></i></a></td>
						</tr>
					<?php
					}
					?>
			</tbody>
		</table>
		<?php
		} else {
		echo "<p><em>Pas de points de vente.</em></p>";
		}
		?>
	</div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>