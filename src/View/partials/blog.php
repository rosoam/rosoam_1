<?php
/**
 * Created by PhpStorm.
 * User: rso
 * Date: 22.05.2018
 * Time: 09:22
 */
?>
<?php
$fetch_blog = $blog->fetchAll();
foreach ($fetch_blog as $post)
{
    $this->newPost($post);
    ?>
<div class="blog blog-blog-post ">
    <a href="/posts/<?= htmlspecialchars($this->_article->getSlug()) ?>" class="blog-post-link">
        <img src="<?php if($this->_article->getCouverture() === ""){ echo "https://via.placeholder.com/800x600.png?text=BLOG";} else { echo htmlspecialchars($this->_article->getCouverture()); }; ?>" class="blog-post-couverture" alt="couverture de l'article">
    </a>
    <div class="blog-blog-post-body">
        <a href="/posts/<?= htmlspecialchars($this->_article->getSlug()) ?>" class="blog-post-link"></a>
        <span class="blog-blog-infos"><span class="categorie">
            <?php
                $categories = $this->_post->categories($post['id_article']);
                $this->newCategorie($categories->fetch());
                $count = $categories->rowCount();
                if($count > 0)
                {
                    echo htmlspecialchars($this->_categorie->getNom());
                }
                else
                {
                    echo "Aucune categorie";
                }
                $categories->closeCursor();
            ?></span> | <?= htmlspecialchars($this->_article->getPublication())  ?> BY <?= htmlspecialchars($this->_article->getAuteur()) ?></span><br>
        <h3><?= htmlspecialchars($this->_article->getTitre()) ?></h3>
    </div>
</div>
<?php }
$blog->closeCursor();
?>
