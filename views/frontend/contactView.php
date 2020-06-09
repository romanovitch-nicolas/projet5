<?php
$title = "Contact";
$meta_description = "Une question ? Un conseil ? Un problème ? N'hésitez pas à nous contacter !";
$meta_url = "www.projet5.n-romano.fr/contact";
?>

<?php ob_start(); ?>

<h1 class="title">Contact</h1>

<section id="contact">
	<div id="accessmap">
		<img src="public/images/contents/map.jpg" alt="Plan d'accès" />
		<div id="accessmap_info">
			<h2>Ferme Haffner - Gaec du Fumé Lorrain</h2>
			<p>
				12 Grande Rue,<br />
				54540 Montigny
			</p>
			<p>
				Tel : 00.00.00.00.00<br />
				Mail : test@gmail.com
			</p>
			<h3>Comment s'y rendre :</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum condimentum ac lorem ut consequat. Nulla mattis arcu vehicula urna hendrerit, vitae mattis nisi volutpat. Nulla ullamcorper risus eu interdum porttitor. Nam vehicula leo vitae urna ultrices malesuada. Fusce tincidunt risus sed neque bibendum, vel rutrum nibh molestie.</p>
			<h3>Horaires d'ouvertures :</h3>
			<p>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit,<br />
				vestibulum condimentum ac lorem ut consequat.
			</p>
		</div>
	</div>

	<h3 class="center">Ecrivez-nous</h3>

	<?php if (isset($return) && $return === true) { echo '<p class="return"><i class="fas fa-check"></i> Votre message a bien été envoyé.</p>'; } ?>
	<?php if (isset($return) && $return !== true) { echo '<p class="return red"><i class="fas fa-exclamation-circle"></i> ' . $return . '</p>'; } ?>

	<form <?php if (isset($return) && $return === true) { echo 'class="invisible"'; } ?> method="POST" action="message-envoye">
		<table>
			<tr>
				<td><label for="messageAuthor">Nom, Prénom</label></td>
				<td><input type="text" id="messageAuthor" name="author" maxlength="255" value ="<?php if (isset($_POST['author'])) { echo $_POST['author']; } ?>" required /></td>
			</tr>
			<tr>
				<td><label for="messageMail">Email</label></td>
				<td><input type="email" id="messageMail" name="mail" maxlength="255" value ="<?php if (isset($_POST['mail'])) { echo $_POST['mail']; } ?>" required /></td>
			</tr>
			<tr>
				<td><label for="messageSubject">Objet</label></td>
				<td><input type="text" id="messageSubject" name="subject" maxlength="255" value ="<?php if (isset($_POST['subject'])) { echo $_POST['subject']; } ?>" required /></td>
			</tr>
			<tr>
				<td><label for="messageContent">Message</label></td>
				<td><textarea id="messageContent" name="content" required><?php if (isset($_POST['content'])) { echo $_POST['content']; } ?></textarea></td>
			</tr>
		</table>
		<p class="center"><input class="button" type="submit" name="sendMessage" value="Envoyer" /></p>
	</form>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>