<?php
$title = "Connexion";
$meta_description = "";
$meta_url = "";
?>

<?php ob_start(); ?>

<h1 class="title">Connexion</h1>

<section id="connect">
	<?php if (isset($return)) { echo '<p class="return red"><i class="fas fa-exclamation-circle"></i> ' . $return . '</p>'; } ?>
	<form method="POST" action="mauvais-identifiants">
		<table>
			<tr>
				<td><label for="login">Identifiant</label></td>
				<td><input type="text" name="login" maxlength="255" required /></td>
			</tr>
			<tr>
				<td><label for="pass">Mot de passe</label></td>
				<td><input type="password" name="pass" maxlength="255" required /></td>
			</tr>
			<tr>
				<td><label for="autoconnect">Rester connecté</label></td>
				<td><input type="checkbox" name="autoconnect" /></td>
			</tr>
		</table>
		<p class="center"><input type="submit" class="button" name="connexion" value="Se connecter" /></p>
	</form>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>