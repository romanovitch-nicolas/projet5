<?php
$title = "Ecrire un article";
$meta_description = "";
$meta_url = "";
?>

<?php ob_start(); ?>
<h1 class="title">Ecrire un article</h1>

<section id="newpost">
	<a class="button" href="<?= LINK_ADMIN_POSTS ?>">Retour à la liste des articles</a>

	<?php if (isset($return)) { echo '<p class="return red"><i class="fas fa-exclamation-circle"></i> ' . $return . '</p>'; } ?>
	<form method="POST" action="index.php?action=addPost" enctype="multipart/form-data">
		<table>
			<tr>
				<td><label for="postTitle">Titre</label></td>
				<td><input type="text" id="postTitle" name="title" maxlength="255" value="<?php if (isset($_POST['title'])) { echo $_POST['title']; } ?>" placeholder="Titre de l'article" required /></td>
			</tr>
			<tr>
				<td><label for="editor">Texte</label></td>
				<td><textarea id="editor" name="content"><?php if (isset($_POST['content'])) { echo $_POST['content']; } ?></textarea></td>
			</tr>
			<tr>
				<td><label>Image</label></td>
				<td>
					<input type="file" name="image" required />
					<p class="date">(Taille maximale : 2 Mo. | Formats d'image acceptés : .jpg, .jpeg, .png, .gif.)</p>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="center"><input class="button" type="submit" name="addPost" value="Enregistrer" /></td>
			</tr>
		</table>
	</form>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>