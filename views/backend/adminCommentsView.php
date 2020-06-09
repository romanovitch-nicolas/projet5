<?php
$title = "Gérer les commentaires";
$meta_description = "";
$meta_url = "";
?>

<?php ob_start(); ?>    
    
<h1 class="title">Gérer les commentaires</h1>

<section id="admincomments">
<?php
$commentExist = count($comments);
if($commentExist) {
?>
	<table>
		<thead>
			<tr>
				<th>Date et heure</th>
				<th>Article</th>
				<th>Auteur</th>
				<th>Mail</th>
				<th>Commentaire</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($comments as $comment) {
			?>
				<tr>
					<td>
						<?php if($comment->report() == 1) { echo '<i class="fas fa-exclamation-circle" title="Commentaire signalé"></i>'; } ?>
						<?= $comment->commentDate() ?>
					</td>
					<td><a href="<?= LINK_POST . transform_into_url(utf8_encode($comment->postTitle())) . '-' . $comment->postId() ?>"><?= $comment->postTitle() ?></a></td>
					<td><?= $comment->author() ?></td>
					<td><?= $comment->mail() ?></td>
					<td><?= nl2br($comment->comment()) ?></td>
					<td><?php if($comment->report() == 1) { ?>
							<a href="index.php?action=deleteCommentReport&amp;id=<?= $comment->id() ?>" title="Approuver"><i class="fas fa-check"></i></i></a>
						<?php } ?>
						<a href="index.php?action=deleteComment&amp;id=<?= $comment->id() ?>" onclick="if(confirm('Supprimer définitivement ?')){return true;}else{return false;}" title="Supprimer"><i class="fas fa-trash"></i></a>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php
		if($numberOfPages > 1) {
			echo "<p class='center'>Pages : ";
			for ($i = 1; $i <= $numberOfPages; $i++) {
		    	$link = '<a href="' . LINK_ADMIN_COMMENTS . '-' . $i . '">' . $i . '</a> ';
			    pagination($link, $numberOfPages, $currentPage, $i);
			}
			echo "</p>";
		}
} else {
?>
	<p><em>Pas de commentaires.</em></p>
<?php 
}
?>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>