<?php
$title = "Modifier un produit";
$meta_description = "";
$meta_url = "";
?>

<?php ob_start(); ?>
<h1 class="title">Modifier un produit</h1>

<section id="editproduct">
	<div id="editbuttons">
		<a class="button" href="<?= LINK_ADMIN_PRODUCTS ?>">Retour à la liste des produits</a>
		<a class="button" href="index.php?action=deleteProduct&amp;id=<?= $product->id() ?>" onclick="if(confirm('Supprimer définitivement ?')){return true;}else{return false;}">Supprimer le produit</a>
	</div>

	<?php if (isset($return)) { echo '<p class="return red"><i class="fas fa-exclamation-circle"></i> ' . $return . '</p>'; } ?>
	<form method='post' action="index.php?action=editProduct&amp;id=<?= $product->id() ?>" enctype="multipart/form-data">
		<table>
			<tr>
				<td><label for="productName">Nom</label></td>
				<td><input type="text" id="productName" name="name" maxlength="255" value="<?php if (isset($_POST['name'])) { echo $_POST['name']; } else { echo htmlspecialchars_decode($product->name()); } ?>" placeholder="Nom du produit" required /></td>
			</tr>
			<tr>
				<td><label for="editor">Description</label></td>
				<td><textarea name="description" id="editor"><?php if (isset($_POST['description'])) { echo ['$_POSTdescription']; } else { echo htmlspecialchars_decode($product->description()); } ?></textarea></td>
			</tr>
			<tr>
				<td><label>Image actuelle</label></td>
				<td><img src="public/images/products/<?= $product->imageName() ?>" alt="Photo du produit" /></td>
			</tr>
			<tr>
				<td></td>
				<td><span class="button">Modifier l'image</span>
					<input type="file" name="image" />
					<p class="date">(Taille maximale : 2 Mo. | Formats d'image acceptés : .jpg, .jpeg, .png, .gif.)</p>
				</td>
			</tr>
			<tr>
				<td><label for="productCategory">Catégorie</label></td>
				<td>
					<select id="productCategory" name="category" required>
						<option value="<?= $product->categoryId() ?>">--Catégorie actuelle : <?= utf8_decode($product->categoryName()) ?>--</option>
				        <?php
				        while ($category = $categories->fetch()) { ?>
				            <option value="<?= $category['id'] ?>"><?= utf8_decode($category['name']) ?></option>
				        <?php 
				        }
				        $categories->closeCursor();
				        ?>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="center"><input class="button" type="submit" name="saveProduct" value="Enregistrer" /></td>
			</tr>
		</table>
	</form>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>