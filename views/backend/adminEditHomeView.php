<?php
$title = "Modifier la page d'accueil";
$meta_description = "";
$meta_url = "";
?>

<?php ob_start(); ?>    
    
<h1 class="title">Modifier la page d'accueil</h1>

<section id="edithome">
	<?php if (isset($return)) { echo '<p class="return red"><i class="fas fa-exclamation-circle"></i> ' . $return . '</p>'; } ?>
	<form method="POST" action="index.php?action=editHome" enctype="multipart/form-data">
		<table>
			<tr>
				<td><label>Bannière actuelle</label></td>
				<td><img src="public/images/contents/<?= $data->banner() ?>" alt="Bannière" /></td>
			</tr>
			<tr>
				<td></td>
				<td><span class="button">Modifier la bannière</span>
					<input type="file" name="banner" />
					<p class="date">(Taille maximale : 2 Mo. | Formats d'image acceptés : .jpg, .jpeg, .png, .gif.)</p>
				</td>
			</tr>
			<tr>
				<td><label for="editor">Texte</label></td>
				<td><textarea name="text" id="editor"><?php if (isset($_POST['text'])) { echo $_POST['text']; } else { echo htmlspecialchars_decode($data->textOne()); } ?></textarea></td>
			</tr>
		</table>
		<p class="center"><input class="button" type="submit" name="editHome" value="Enregistrer" /></p>
	</form>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>