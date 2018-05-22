<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 16:36
 */

$title = "Bienvenue sur la page des posts!";

ob_start();
?>
    <section id="posts" class="posts-section section">
        <div class="posts-container container">
            <div class="row posts-title-area">
                <div class="col-12">
                    <h2>Le blog</h2>
                </div>
            </div>
            <div class="row posts-content-area">
                <div class="col-12 col-md-10">
                    <div class="row post-tags-area">
                        <div class="col-12 tags-carousel">
                            <!-- Generated -->
                            <!-- Generated -->
                            <!-- Generated -->
                            <?php
                            $tags = $post_management->all_tags();
                            $fetch_tags = $tags->fetchAll();
                            foreach($fetch_tags as $tag)
                            {?>
                                <div class="tag-item"><p><a href="#"><?= htmlspecialchars($tag['nom_tag']); ?></a></p></div>
                            <?php }?>
                            <!-- Generated -->
                            <!-- Generated -->
                            <!-- Generated -->
                            <a class="tag_search" href="#">search</a>
                        </div>
                    </div>
                    <div class="all-posts the-blog">
                        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/blog.php'; ?>
                    </div>
                </div>
                <div class="col-12 col-md-2 filtres-area">
                    <div class="auteurs-area">
                        <form>
                            <h3>Auteur</h3>
                            <div class="form-row">
                                <div class="col-12 col-lg-8">
                                    <input type="text" id="auteur" class="form-control" placeholder="Auteur">
                                </div>
                                <div class="col-12 col-lg-4">
                                    <button type="submit" class="btn btn-primary form-control get-auteur-posts" placeholder="Look!">Look!</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr/>
                    <div class="categories-area">
                        <h3>Les catégories</h3>
                        <div class="categories">
                            <ul>
                                <!-- Generated -->
                                <!-- Generated -->
                                <!-- Generated -->
                                <?php
                                $categories = $post_management->all_categories();
                                foreach($categories->fetchAll() as $categorie)
                                {?>
                                    <li><a class="post-categorie" href="#"><?= htmlspecialchars($categorie['nom_categorie']); ?></a></li>
                                <?php } ?>
                                <!-- Generated -->
                                <!-- Generated -->
                                <!-- Generated -->
                            </ul>
                        </div>
                    </div>
                    <hr />
                    <div class="populaires-area">
                        <h3>Les articles populaires</h3>
                        <div class="populaires">
                            <!-- Generated -->
                            <!-- Generated -->
                            <!-- Generated -->
                            <?php
                            $fetch_fav_blog = $fav_blog->fetchAll();
                            foreach($fetch_fav_blog as $fav_article)
                            {?>
                                <div class="item-populaire">
                                    <a href="<?= htmlspecialchars($fav_article['slug_article']); ?>">
                                        <p>
                                            <b><?= htmlspecialchars($fav_article['titre_article']); ?></b> - <span class="likes"><?= htmlspecialchars($fav_article['likes_article']); ?> <i class="fa fa-heart"></i></span> <br> <span> <?= htmlspecialchars($fav_article['article_publication']); ?>, BY <?= htmlspecialchars($fav_article['auteur_article']); ?></span>
                                        </p>
                                    </a>
                                </div>
                            <?php } ?>
                        <!-- Generated -->
                        <!-- Generated -->
                        <!-- Generated -->
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/template/template-post.php';