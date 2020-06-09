<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="icon" href="public/images/contents/favicon.png" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="https://fonts.googleapis.com/css2?family=Montserrat&family=PT+Serif:ital@0;1&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
		<link rel="stylesheet" href="public/css/fontawesome/css/all.css" />
		<link rel="stylesheet" href="public/css/style.css" /> 
		<title><?= $title . " - Ferme Haffner" ?></title>
		<meta name="description" content="<?= $meta_description ?>" />
        <meta property="og:title" content="<?= $title ?> - Ferme Haffner" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="<?= $meta_url ?>" />
        <meta property="og:image" content="https://nsa40.casimages.com/img/2020/04/24/200424105943236933.png" />
        <meta property="og:description" content="<?= $meta_description ?>" />
	</head>

	<body>
		<header>
			<a href="<?= LINK_HOME ?>"><img src="public/images/contents/logo.png" alt="Logo" /></a>
			<nav>
				<ul>
					<li><a href="<?= LINK_HOME ?>" <?php if($_GET['action'] == 'home' || !isset($_GET['action'])) { echo 'class="active"'; } ?>>Accueil</a></li>
					<li><a href="<?= LINK_LABEL ?>" <?php if($_GET['action'] == 'label') { echo 'class="active"'; } ?>>Bleu Blanc Coeur</a></li>
					<li><a href="<?= LINK_PRODUCTS ?>" <?php if($_GET['action'] == 'listProducts') { echo 'class="active"'; } ?>>Nos produits</a></li>
					<li><a href="<?= LINK_SHOPS ?>" <?php if($_GET['action'] == 'shops') { echo 'class="active"'; } ?>>Points de vente</a></li>
					<li><a href="<?= LINK_BLOG ?>" <?php if($_GET['action'] == 'listPosts' || $_GET['action'] == 'post') { echo 'class="active"'; } ?>>Blog</a></li>
					<li><a href="<?= LINK_ABOUT ?>" <?php if($_GET['action'] == 'about') { echo 'class="active"'; } ?>>A propos</a></li>
					<li><a href="<?= LINK_CONTACT ?>" <?php if($_GET['action'] == 'contact' || ($_GET['action'] == 'sendMail')) { echo 'class="active"'; } ?>>Contact</a></li>
					<?php if (isset($_SESSION['login']) OR isset($_COOKIE['login'])) { ?>
						<br />
						<li><a href="<?= LINK_ADMIN ?>" <?php if(strpos($_GET['action'], 'admin') !== false) { echo 'class="active"'; } ?>>Administration</a></li>
						<li><a href="index.php?action=disconnect">Se déconnecter</a></li>
				    <?php } ?>
				</ul>
			</nav>
			<p><a href="https://www.facebook.com/fermehaffner/?hc_ref=ARR6VXFwRg7LbBimQJTZCbNsMzKq9JcQt_GmO1s-iIc8Z6t4TCd4FT-xTcSJ24Ut2nc&fref=nf&__tn__=kC-R" target="_blank"><i class="fab fa-facebook-square fa-2x"></i></a></p>
			<form method="POST" action="recherche" id="search"><i class="fas fa-search"></i><input type="search" name="search" placeholder="Recherche..." /><input type="submit" class="invisible" /></form>
		</header>
		<div id="mobile_header">
			<i id="burger" class="fas fa-bars fa-2x"></i>
			<a href="<?= LINK_HOME ?>"><img src="public/images/contents/logo.png" alt="Logo" /></a>
		</div>
		<div id="background"></div>

		<?= $content ?>

		<div id="cookies" <?php if(isset($_COOKIE['cookies'])) { echo 'class="invisible"'; } ?>>
			<p>Ce site utilise des cookies afin d'analyser le taux de fréquentation, et identifier d'éventuels soucis de navigation.</p>
			<p><span id="accept_cookies" class="button">Accepter</span><span id="refuse_cookies" class="button">Refuser</span><a href="mentions-legales">En savoir plus</a></p>
		</div>

		<footer>
			<p><a href="<?= LINK_LABEL ?>">Bleu Blanc Coeur</a> | <a href="<?= LINK_PRODUCTS ?>">Nos produits</a> | <a href="<?= LINK_SHOPS ?>">Points de vente</a> | <a href="<?= LINK_BLOG ?>">Blog</a> | <a href="<?= LINK_ABOUT ?>">A propos</a> | <a href="<?= LINK_CONTACT ?>">Contact</a> | <a href="mentions-legales">Mentions légales</a></p>
			<p><a href="https://www.facebook.com/fermehaffner/?hc_ref=ARR6VXFwRg7LbBimQJTZCbNsMzKq9JcQt_GmO1s-iIc8Z6t4TCd4FT-xTcSJ24Ut2nc&fref=nf&__tn__=kC-R" target="_blank"><i class="fab fa-facebook-square fa-2x"></i></a></p>
			<p>Adresse mail<br />
			Numéro de teléphone</p>
		</footer>

		<script src="https://cdn.tiny.cloud/1/cwe4o8zjsewx7soze93j3wl2ihp0pb8l09n9fqjy3czfgbu9/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
		<script src="public/js/app.js"></script>
		<script src="public/js/display.js"></script>
	</body>
</html>