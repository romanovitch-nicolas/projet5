<?php
$title = 'Modifier la page "A propos"';
$meta_description = "";
$meta_url = "";
?>

<?php ob_start(); ?>    
    
<h1 class="title">Modifier la page "A propos"</h1>

<section id="editabout">
	<?php if (isset($return)) { echo '<p class="return red"><i class="fas fa-exclamation-circle"></i> ' . $return . '</p>'; } ?>
	<form method="POST" action="index.php?action=editAbout" enctype="multipart/form-data">
		<div class="column">
			<table>
				<tr>
					<td><label>Image actuelle 1</label></td>
					<td><img src="public/images/contents/<?= $data->imageOne() ?>" alt="A propos 1" /></td>
				</tr>
				<tr>
					<td></td>
					<td><span class="button">Modifier l'image</span>
						<input type="file" name="image_1" />
						<p class="date">(Taille maximale : 2 Mo. | Formats d'image acceptés : .jpg, .jpeg, .png, .gif.)</p>
					</td>
				</tr>
				<tr>
					<td><label for="editor">Texte 1</label></td>
					<td><textarea name="text_1" class="editor"><?php if (isset($_POST['text_1'])) { echo $_POST['text_1']; } else { echo htmlspecialchars_decode($data->textOne()); } ?></textarea></td>
				</tr>
			</table>
			<table>
				<tr>
					<td><label>Image actuelle 2</label></td>
					<td><img src="public/images/contents/<?= $data->imageTwo() ?>" alt="A propos 2" /></td>
				</tr>
				<tr>
					<td></td>
					<td><span class="button two">Modifier l'image</span>
						<input class="two" type="file" name="image_2" />
						<p class="date two">(Taille maximale : 2 Mo. | Formats d'image acceptés : .jpg, .jpeg, .png, .gif.)</p>
					</td>
				</tr>
				<tr>
					<td><label for="editor">Texte 2</label></td>
					<td><textarea name="text_2" class="editor"><?php if (isset($_POST['text_2'])) { echo $_POST['text_2']; } else { echo htmlspecialchars_decode($data->textTwo()); } ?></textarea></td>
				</tr>
			</table>
		</div>
		<div class="center"><input class="button" type="submit" name="editAbout" value="Enregistrer" /></div>
	</form>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>