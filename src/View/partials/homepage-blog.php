<?php
/**
 * Created by PhpStorm.
 * User: rso
 * Date: 04.05.2018
 * Time: 11:46
 */
?>
<?php
$fetch_blog = $blog->fetchAll();
foreach ($fetch_blog as $post)
{ ?>
    <div class="blog-post box">
        <img src="<?php if($post['couverture_article'] === ""){ echo "https://via.placeholder.com/800x600.png?text=BLOG";} else { echo htmlspecialchars($post['couverture_article']); }; ?>" class="blog-post-couverture" alt="couverture de l'article <?= htmlspecialchars($post['titre_article']) ?>">
        <a href="/posts/<?= htmlspecialchars($post['slug_article']) ?>" class="blog-post-link">
            <div class="blog-post-header">
                <h3><?= htmlspecialchars($post['titre_article']) ?></h3>
            </div>
            <div class="blog-post-body">

            </div>
            <div class="blog-post-footer">

            </div>
        </a>
        <div class="blog-post-likes">
            <i class="fa fa-heart"></i>
            <span class="number-of-likes"><?= htmlspecialchars($post['likes_article']) ?></span>
        </div>
    </div>
<?php }
$blog->closeCursor();
?>