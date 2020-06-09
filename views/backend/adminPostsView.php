<?php
$title = "Gérer les articles";
$meta_description = "";
$meta_url = "";
?>

<?php ob_start(); ?>    
    
<h1 class="title">Gérer les articles</h1>

<section id="adminposts">
	<p><a class="button" href="<?= LINK_ADMIN_NEW_POST ?>">Écrire un article</a></p>

	<?php
	$postExist = count($posts);
	if($postExist) {
	?>
		<table>
			<thead>
				<tr>
					<th>Date</th>
					<th>Image</th>
					<th>Titre</th>
					<th>Extrait</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($posts as $post)
				{
				?>
					<tr>
						<td><?= $post->creationDate() ?></td>
						<td><?php if (!empty($post->imageName())) { ?>
								<img src="public/images/posts/<?= $post->imageName() ?>" alt="Image de l'article" />
							<?php } ?></td>
						<td><a class="bold" href="<?= LINK_POST . transform_into_url(utf8_encode($post->title())) . '-' . $post->id() ?>"><?= $post->title() ?></a></td>
						<td><?php 
					        $postDescription = nl2br(strip_tags(htmlspecialchars_decode($post->content())));
					        echo substr($postDescription, 0, 200) . '...';
				        	?></td>
						<td>
							<a href="<?= LINK_ADMIN_EDIT_POST . $post->id() ?>" title="Modifier"><i class="fas fa-edit"></i></a>
							<a href="index.php?action=deletePost&amp;id=<?= $post->id() ?>" onclick="if(confirm('Supprimer définitivement ?')){return true;}else{return false;}" title="Supprimer"><i class="fas fa-trash"></i></a>
							<?php if($post->online() == 0) { ?>
								<a href="index.php?action=onlinePost&amp;id=<?= $post->id() ?>" title="Rendre public"><i class="fas fa-eye-slash"></i></a>
							<?php } else { ?>
								<a href="index.php?action=offlinePost&amp;id=<?= $post->id() ?>" title="Rendre privé"><i class="fas fa-eye"></i></a>
							<?php } ?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>

	<?php
	} else {
	?>
		<p><em>Pas d'articles.</em></p>
	<?php 
	}
	if($numberOfPages > 1) {
		echo "<p class='center'>Pages : ";
		for ($i = 1; $i <= $numberOfPages; $i++) {
		    $link = '<a href="' . LINK_ADMIN_POSTS . '-' . $i . '">' . $i . '</a> ';
			pagination($link, $numberOfPages, $currentPage, $i);
		}
		echo "</p>";
	}
	?>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>