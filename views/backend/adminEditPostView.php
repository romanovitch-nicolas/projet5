<?php
$title = "Modifier un article";
$meta_description = "";
$meta_url = "";
?>

<?php ob_start(); ?>
<h1 class="title">Modifier un article</h1>

<section id="editpost">
	<div id="editbuttons">
		<a class="button" href="<?= LINK_ADMIN_POSTS ?>">Retour à la liste des articles</a>
		<a class="button" href="index.php?action=deletePost&amp;id=<?= $post->id() ?>" onclick="if(confirm('Supprimer définitivement ?')){return true;}else{return false;}">Supprimer l'article</a>
	</div>

	<?php if (isset($return)) { echo '<p class="return red"><i class="fas fa-exclamation-circle"></i> ' . $return . '</p>'; } ?>
	<form method='post' action="index.php?action=editPost&amp;id=<?= $post->id() ?>" enctype="multipart/form-data">
		<table>
			<tr>
				<td><label for="postTitle">Titre</label></td>
				<td><input type="text" id="postTitle" name="title" maxlength="255" value="<?php if (isset($_POST['title'])) { echo $_POST['title']; } else { echo htmlspecialchars_decode($post->title()); } ?>" required /></td>
			</tr>
			<tr>
				<td><label for="editor">Texte</label></td>
				<td><textarea name="content" id="editor"><?php if (isset($_POST['content'])) { echo $_POST['content']; } else { echo htmlspecialchars_decode($post->content()); } ?></textarea></td>
			</tr>
			<tr>
				<td><label>Image actuelle</label></td>
				<td><img src="public/images/posts/<?= $post->imageName() ?>" alt="Image de l'article" /></td>
			</tr>
			<tr>
				<td></td>
				<td><span class="button">Modifier l'image</span>
					<input type="file" name="image" />
					<p class="date">(Taille maximale : 2 Mo. | Formats d'image acceptés : .jpg, .jpeg, .png, .gif.)</p>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="center"><input class="button" type="submit" name="savePost" value="Enregistrer" /></td>
			</tr>
		</table>
	</form>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>