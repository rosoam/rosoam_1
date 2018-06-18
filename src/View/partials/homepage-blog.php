<?php
/**
 * Created by PhpStorm.
 * User: rso
 * Date: 04.05.2018
 * Time: 11:46
 */

$fetch_blog = $blog->fetchAll();
foreach ($fetch_blog as $post)
{
    $this->newPost($post);
    ?>
    <div class="blog-post box">
        <img src="<?php if($this->_article->getCouverture() === ""){ echo "https://via.placeholder.com/800x600.png?text=BLOG";} else { echo htmlspecialchars($this->_article->getCouverture()); }; ?>" class="blog-post-couverture" alt="couverture de l'article <?= htmlspecialchars($post['titre_article']) ?>">
        <a href="/posts/<?= htmlspecialchars($this->_article->getSlug()) ?>" class="blog-post-link">
            <div class="blog-post-header">
                <h3><?= htmlspecialchars($this->_article->getTitre()) ?></h3>
            </div>
        </a>
        <!--<div class="blog-post-likes">
            <i class="fa fa-heart"></i>
            <span class="number-of-likes"> //htmlspecialchars($this->_article->getLikes()) </span>
        </div>-->
    </div>
<?php }
$blog->closeCursor();
?>