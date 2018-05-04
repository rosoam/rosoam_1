<?php
/**
 * Created by PhpStorm.
 * User: rso
 * Date: 04.05.2018
 * Time: 15:01
 */
?>
<?php
$posts_teaser = $new_posts_teaser->posts("id_article", 5, true);
$fetch_posts_teaser = $posts_teaser->fetchAll();
if(count($fetch_posts_teaser) > 0)
{
    foreach ($fetch_posts_teaser as $post)
    { ?>
        <div class="article-box">
            <img src="<?= htmlspecialchars($post['couverture_article']) ?>" alt="image de couverture, article : <?= htmlspecialchars($post['titre_article']) ?>" class="article-couverture">
            <a href="/posts/<?= htmlspecialchars($post['slug']) ?>">
                <div class="article-header">
                    <h3><?= htmlspecialchars($post['titre_article']) ?></h3>
                </div>
                <div class="article-tags">
                    <?php
                    $tags_post = $new_posts_teaser->tags($post['id_article']);
                    $fetch_tags = $tags_post->fetchAll();
                    if(count($fetch_tags) > 0)
                    {
                        foreach($fetch_tags as $tag)
                        {?>
                            <p><?= $tag['nom_tag'] ?></p>
                        <?php }
                        $tags_post->closeCursor();
                    }
                    else
                    {?>
                        <p>Aucun tag</p>
                    <?php }
                    ?>
                </div>
            </a>
        </div>
    <?php }
} else
{ ?>
    <p>Vous n'avez aucun article</p>
<?php }
$posts_teaser->closeCursor();
?>
