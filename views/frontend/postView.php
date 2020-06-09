<?php
$title = htmlspecialchars_decode($post->title());
$meta_description = nl2br(htmlspecialchars_decode(substr($post->content(), 0, 300))) . '...';
$meta_url = "www.projet5.n-romano.fr/blog-" . transform_into_url(utf8_encode($post->title())) . "-" . $post->id();
?>

<?php ob_start(); ?>    
    
<h1 class="title"><?= $post->title() ?></h1>

<section id="postcontent">
    <a class="button" href="<?= LINK_BLOG ?>">Retour à la liste des articles</a>

    <?php if (!empty($post->imageName())) { ?>
        <div class="center">
            <img src="public/images/posts/<?= $post->imageName() ?>" alt="Image de l'article" />
        </div>
    <?php } ?>
    <h2>
        <span class="serif"><?= $post->title() ?></span> <span class="date">le <?= $post->creationDate() ?></span>
    </h2>
    <p>
        <?= nl2br(htmlspecialchars_decode($post->content())) ?>
    </p>
</section>

<section id="postcomments">
    <h2 class="serif">Commentaires</h2>

    <span class="button">Ajouter un commentaire</span>
    <div id="form" <?php if (!isset($return)) { echo "class=invisible"; } ?>>
        <?php if (isset($return)) { echo '<p class="return red"><i class="fas fa-exclamation-circle"></i> ' . $return . '</p>'; } ?>
        <form action="index.php?action=addComment&amp;id=<?= $post->id() ?>" method="post">
            <div>
                <label for="formcomment_author">Nom, Prénom</label><br />
                <input type="text" id="formcomment_author" name="author" maxlength="255" value="<?php if (isset($_POST['author'])) { echo $_POST['author']; } ?>" required />
            </div>
            <div>
                <label for="formcomment_mail">Adresse Mail</label><br />
                <input type="email" id="formcomment_mail" name="mail" maxlength="255" value="<?php if (isset($_POST['mail'])) { echo $_POST['mail']; } ?>" required />
            </div>
            <div>
                <label for="formcomment_content">Commentaire</label><br />
                <textarea id="formcomment_content" name="comment" required><?php if (isset($_POST['comment'])) { echo $_POST['comment']; } ?></textarea>
            </div>
            <div>
                <input class="button" type="submit" name="addComment" value="Envoyer" />
            </div>
        </form>
    </div>

    <?php
    $commentExist = count($comments);
    if($commentExist) {
        foreach ($comments as $comment) {
        ?>
            <div class="comment">
                <?php if($comment->report() == 0) { ?>
                    <p><strong><?= $comment->author() ?></strong><?php } else { echo '<p><em><strong>Inconnu</strong></em>'; }?>, <span class="date">le <?= $comment->commentDate() ?></span>
                    <a href="index.php?action=reportComment&amp;comment_id=<?= $comment->id() ?>&amp;post_id=<?= $comment->postId() ?>" title="Signaler le commentaire" onclick="if(confirm('Signaler ce commentaire ?')){return true;}else{return false;}"><i class="fas fa-exclamation-circle"></i></a></p>
                <?php if($comment->report() == 0) { ?> 
                    <p><?= nl2br($comment->comment()) ?></p></div>
            <?php }
            else {
                echo '<p><em>Ce commentaire a été signalé.</em></p></div>'; 
            }
        }
    } else { 
        echo '<p><em>Soyez le premier à poster un commentaire sur cet article !</em></p>';
    }

    if($numberOfPages > 1) {
        echo "<p class='center'>Pages : ";
        for ($i = 1; $i <= $numberOfPages; $i++) {
            $link = '<a href="' . LINK_POST . transform_into_url(utf8_encode($post['title'])) . '-' . $_GET['id'] . '-' . $i . '">' . $i . '</a> ';
            pagination($link, $numberOfPages, $currentPage, $i);
        }
        echo "</p>";
    }
    ?>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('views/template.php'); ?>