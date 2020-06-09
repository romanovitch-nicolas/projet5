<?php
$title = "Gérer les produits";
$meta_description = "";
$meta_url = "";
?>

<?php ob_start(); ?>    
    
<h1 class="title">Gérer les produits</h1>

<section id="adminproducts">
	<div>
		<a class="button" href="<?= LINK_ADMIN_NEW_PRODUCT ?>">Ajouter un produit</a>
		<form method="POST" action="<?= LINK_ADMIN_PRODUCTS ?>">
			<select name="product_category">
				<option value="">--Toutes les catégories--</option>
		        <?php
		        while ($category = $categories->fetch()) { ?>
		            <option value="<?= $category['id'] ?>"><?= utf8_decode($category['name']) ?></option> - 
		        <?php 
		        }
		        $categories->closeCursor();
		        ?>
			</select>
			<input class="button" type="submit" name="sortProduct" value="Filtrer" />
		</form>
	</div>

	<?php
	$productExist = count($products);
	if($productExist) {
	?>
		<table>
			<thead>
				<tr>
					<th>Date</th>
					<th>Image</th>
					<th>Produit</th>
					<th>Description</th>
					<th>Catégorie</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($products as $product)
				{
				?>
					<tr>
						<td><?= $product->creationDate() ?></td>
						<td><?php if (!empty($product->imageName())) { ?>
								<img src="public/images/products/<?= $product->imageName() ?>" alt="Photo du produit" />
							<?php } ?></td>
						<td><a href="<?= LINK_PRODUCTS . '-' . transform_into_url($product->categoryName()) . '-' . $product->categoryId() ?>"><?= $product->name() ?></td>
						<td><?php 
					        $productDescription = nl2br(strip_tags(htmlspecialchars_decode($product->description())));
					        echo substr($productDescription, 0, 150) . '...';
				        	?></td>
				        <td><?= utf8_decode($product->categoryName()) ?></td>
						<td>
							<a href="<?= LINK_ADMIN_EDIT_PRODUCT . $product->id() ?>" title="Modifier"><i class="fas fa-edit"></i></a>
							<a href="index.php?action=deleteProduct&amp;id=<?= $product->id() ?>" title="Supprimer" onclick="if(confirm('Supprimer définitivement ?')){return true;}else{return false;}"><i class="fas fa-trash"></i></a>
						</td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		<?php
		if($numberOfPages > 1) {
			echo "<p class='center'>Pages : ";
			for ($i = 1; $i <= $numberOfPages; $i++) {
		    	if (isset($categoryId)) {
		    		$link = '<a href="' . LINK_ADMIN_PRODUCTS . '-' . $categoryId . '-' . $i . '">' . $i . '</a> ';
		        }
		        else
			    {
			    	$link = '<a href="' . LINK_ADMIN_PRODUCTS . '-' . $i . '">' . $i . '</a> ';
			    }
			    pagination($link, $numberOfPages, $currentPage, $i);
			}
			echo "</p>";
		}
	} else {
	?>
		<p><em>Pas de produit.</em></p>
	<?php 
	}
	?>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>