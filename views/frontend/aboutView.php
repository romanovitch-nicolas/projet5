<?php 
$title = "A propos";
$meta_description = nl2br(htmlspecialchars_decode(substr($content->textOne(), 0, 300))) . '...';
$meta_url = "www.projet5.n-romano.fr/a-propos";
?>

<?php ob_start(); ?>    
    
<h1 class="title">A propos</h1>

<section id="about">
	<div>
		<img src="public/images/contents/<?= $content->imageOne() ?>" alt="A propos 1" />
	    <p><?= nl2br(htmlspecialchars_decode($content->textOne())) ?></p>
    </div>
    <div>
    	<img src="public/images/contents/<?= $content->imageTwo() ?>" alt="A propos 2" />
    	<p><?= nl2br(htmlspecialchars_decode($content->textTwo())) ?></p>
    </div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>