<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 19:59
 */
?>
<section id="last-news">
    <div class="last-news-content">
        <div class="last-news-area">
            <?php
            $posts = $posts_teaser->posts("id_article", 2, false);
            $teaser_posts = $posts->fetchAll();
            foreach ($teaser_posts as $post)
            { ?>
            <div class="box box1">
                <img src="<?= htmlspecialchars($post['couverture_article']) ?>" alt="image de couverture, article : <?= htmlspecialchars($post['titre_article']) ?>" class="couverture-article">
                <a href="/posts/<?= htmlspecialchars(str_replace(' ', '-', trim($post['titre_article']))) ?>">
                    <div class="box-content">
                        <h3><?= htmlspecialchars($post['titre_article']) ?></h3>
                    </div>
                </a>
            </div>
            <?php }
            $posts->closeCursor();
            ?>
        </div>
    </div>
</section>
