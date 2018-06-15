<?php
/**
 * Created by PhpStorm.
 * User: rso
 * Date: 04.05.2018
 * Time: 15:01
 */
?>
<?php
$fetch_blog = $blog->fetchAll();
if ($blog->rowCount() > 0) {
    foreach ($fetch_blog as $post) {
        $this->newPost($post);
        ?>
        <div class="blog-box">
            <div class="blog user-blog blog-blog-post ">
                <button class="delete-post btn btn-danger" id="<?= htmlspecialchars($this->_article->getId()) ?>">Effacer</button>
                <button class="update-post btn btn-info" id="<?= htmlspecialchars($this->_article->getId()) ?>" data-toggle="modal" data-target="#update-article-modal" >Update</button>
                <a href="/posts/<?= htmlspecialchars($this->_article->getSlug()) ?>" class="blog-post-link">
                    <img src="<?php
                    if ($this->_article->getCouverture() === "") {
                        echo "https://via.placeholder.com/800x600.png?text=BLOG";
                    } else {
                        echo htmlspecialchars($this->_article->getCouverture());
                    };
                    ?>" class="blog-post-couverture" alt="couverture de l'article">
                </a>
                <div class="blog-blog-post-body">
                    <a href="/posts/<?= htmlspecialchars($this->_article->getSlug()) ?>" class="blog-post-link"></a>
                    <span class="blog-blog-infos"><span class="categorie">
            <?php
            $categories = $this->_post->categories($post['id_article']);
            $this->newCategorie($categories->fetch());
            if ($categories->rowCount() > 0) {
                echo htmlspecialchars($this->_categorie->getNom());
            } else {
                echo "Aucune categorie";
            }
            $categories->closeCursor();
            ?></span> | <?= htmlspecialchars($this->_article->getPublication()) ?> BY <?= htmlspecialchars($this->_article->getAuteur()); ?></span><br>
                    <h3><?= htmlspecialchars($this->_article->getTitre()) ?></h3>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    ?>
    <p>Vous n'avez aucun article</p>
    <?php
}
$blog->closeCursor();
?>
