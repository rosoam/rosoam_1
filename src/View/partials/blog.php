<?php
/**
 * Created by PhpStorm.
 * User: rso
 * Date: 04.05.2018
 * Time: 11:46
 */
?>
<?php
$posts_teaser = $new_posts_teaser->posts("id_article", 5, false);
$fetch_posts_teaser = $posts_teaser->fetchAll();
foreach ($fetch_posts_teaser as $post)
{ ?>
<div class="article-box">
    <img src="<?php if($post['couverture_article'] === ""){ echo "https://via.placeholder.com/800x600.png?text=BLOG";} else { echo htmlspecialchars($post['couverture_article']); }; ?>" alt="image de couverture, article : <?= htmlspecialchars($post['titre_article']) ?>" class="article-couverture">
    <a href="/posts/<?= htmlspecialchars($post['slug']) ?>">
        <div class="article-header">
            <h3><?= htmlspecialchars($post['titre_article']) ?></h3>
        </div>
        <div class="article-tags">
            <?php
            $tags_post = $new_posts_teaser->tags($post['id_article']);
            $fetch_tags = $tags_post->fetchAll();
            $count = 0;
            if(count($fetch_tags) > 0)
            {
                foreach($fetch_tags as $tag)
                {
                    $count++;
                    ?>
                    <p>Tag n<?= $count ?> :<?= $tag['nom_tag'] ?></p>
                <?php }
                $tags_post->closeCursor();
            }
            else
            {?>
                <p>Aucun tag</p>
            <?php }
            ?>
        </div>
        <div class="article-categorie">
            <?php
            $categorie_post = $new_posts_teaser->categories($post['id_article']);
            $fetch_categorie = $categorie_post->fetchAll();
            if(count($fetch_categorie) > 0)
            {
                foreach($fetch_categorie as $categorie)
                {?>
                    <p>categorie :<?= $categorie['nom_categorie'] ?></p>
                <?php }
                $categorie_post->closeCursor();
            }
            else
            {?>
                <p>Aucune catégorie</p>
            <?php }
            ?>
        </div>
    </a>
</div>
<?php }
$posts_teaser->closeCursor();
?>