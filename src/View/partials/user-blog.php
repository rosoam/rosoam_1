<?php
/**
 * Created by PhpStorm.
 * User: rso
 * Date: 04.05.2018
 * Time: 15:01
 */
?>
<?php
$blog       = $post_management->posts("id_article", 5, true);
$fetch_blog = $blog->fetchAll();
if (count($fetch_blog) > 0) {
    foreach ($fetch_blog as $post) {
        ?>
        <div class="blog user-blog blog-blog-post ">
            <button class="delete-post btn btn-danger" id="<?= htmlspecialchars($post['id_article']) ?>">Effacer</button>
            <a href="/posts/<?= htmlspecialchars($post['slug_article']) ?>" class="blog-post-link">
                <img src="<?php
                if ($post['couverture_article'] === "") {
                    echo "https://via.placeholder.com/800x600.png?text=BLOG";
                } else {
                    echo htmlspecialchars($post['couverture_article']);
                };
                ?>" class="blog-post-couverture" alt="couverture de l'article">
            </a>
            <div class="blog-blog-post-body">
                <a href="/posts/<?= htmlspecialchars($post['slug_article']) ?>" class="blog-post-link"></a>
                <span class="blog-blog-infos"><span class="categorie">
            <?php
            $categories = $post_management->categories($post['id_article']);
            $categorie  = $categories->fetch();
            $count      = $categories->rowCount();
            if ($count > 0) {
                echo htmlspecialchars($categorie['nom_categorie']);
            } else {
                echo "Aucune categorie";
            }
            $categories->closeCursor();
            ?></span> | <?= htmlspecialchars($post['article_publication']) ?> BY <?= htmlspecialchars($post['auteur_article']); ?></span><br>
                <h3><?= htmlspecialchars($post['titre_article']) ?></h3>
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
