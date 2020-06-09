<?php
$title = "Blog";
$meta_description = "Retrouvez toute l'actualité de la ferme Haffner !";
$meta_url = "www.projet5.n-romano.fr/blog";
?>

<?php ob_start(); ?>

<h1 class="title">Blog</h1>

<section id="listposts">
<?php
$postExist = count($posts);
if($postExist) {
?>
    <?php
        foreach ($posts as $post)
        {
        ?>
            <div id="postpreview">
                <div><?php if (!empty($post->imageName())) { ?><img src="public/images/posts/<?= $post->imageName() ?>" alt="Image de l'article" /><?php } ?></div>
                <div>
                    <h3>
                        <?= htmlspecialchars_decode($post->title()) ?><br />
                        <span class="date">le <?= $post->creationDate() ?></span>
                    </h3>
                        
                    <p>
                        <?php
                        $postDescription = nl2br(strip_tags(htmlspecialchars_decode($post->content())));
                        echo substr($postDescription, 0, 300) . '...';
                        ?>
                    </p>
                    <p><a class="bold" href="<?= LINK_POST . transform_into_url(utf8_encode($post->title())) . '-' . $post->id() ?>">Lire l'article</a></p>
                </div>
            </div>
        <?php
        }
        if($numberOfPages > 1) {
            echo "<p class='center'>Pages : ";
            for ($i = 1; $i <= $numberOfPages; $i++) {
                $link = '<a href="' . LINK_BLOG . '-' . $i . '">' . $i . '</a> ';
                pagination($link, $numberOfPages, $currentPage, $i);
            }
            echo "</p>";
        }
} else { 
    echo "<p><em>Pas d'article disponible.</em></p>";
} ?>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>