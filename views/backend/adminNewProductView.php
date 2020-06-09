<?php
$title = "Ajouter un produit";
$meta_description = "";
$meta_url = "";
?>

<?php ob_start(); ?>
<h1 class="title">Ajouter un produit</h1>

<section id="newproduct">
	<a class="button" href="<?= LINK_ADMIN_PRODUCTS ?>">Retour à la liste des produits</a>

	<?php if (isset($return)) { echo '<p class="return red"><i class="fas fa-exclamation-circle"></i> ' . $return . '</p>'; } ?>
	<form method="POST" action="index.php?action=addProduct" enctype="multipart/form-data">
		<table>
			<tr>
				<td><label for="productName">Nom</label></td>
				<td><input type="text" id="productName" name="name" maxlength="255" value="<?php if (isset($_POST['name'])) { echo $_POST['name']; } ?>" placeholder="Nom du produit" required /></td>
			</tr>
			<tr>
				<td><label for="editor">Description</label></td>
				<td><textarea id="editor" name="description"><?php if (isset($_POST['description'])) { echo $_POST['description']; } ?></textarea></td>
			</tr>
			<tr>
				<td><label>Image</label></td>
				<td>
					<input type="file" name="image" required />
					<p class="date">(Taille maximale : 2 Mo. | Formats d'image acceptés : .jpg, .jpeg, .png, .gif.)</p>
				</td>
			</tr>
			<tr>
				<td><label for="productCategory">Catégorie</label></td>
				<td>
					<select id="productCategory" name="category" required>
						<option value="">--Choisir une catégorie--</option>
				        <?php
				        while ($category = $categories->fetch()) { ?>
				            <option value="<?= $category['id'] ?>"><?= utf8_decode($category['name']) ?></option> - 
				        <?php 
				        }
				        $categories->closeCursor();
				        ?>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="center"><input class="button" type="submit" name="addProduct" value="Ajouter" /></td>
			</tr>
		</table>
	</form>
	
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>