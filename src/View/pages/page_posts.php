<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 16:36
 */

$title = "Projet Maccaud - Le blog";

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
                                $categories = $this->_post->all_categories();
                                foreach($categories->fetchAll(PDO::FETCH_ASSOC) as $categorie)
                                {
                                   $this->newCategorie($categorie);
                                    ?>
                                    <li><a class="post-categorie" href="#"><?= htmlspecialchars($this->_categorie->getNom()); ?></a></li>
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
                            $fav_blog = $this->_post->posts("likes_article",3,false);
                            $fetch_fav_blog = $fav_blog->fetchAll(PDO::FETCH_ASSOC);
                            foreach($fetch_fav_blog as $fav_article)
                            {
                                $this->newPost($fav_article);
                                ?>
                                <div class="item-populaire">
                                    <a href="/posts/<?= htmlspecialchars($this->_article->getSlug()); ?>">
                                        <p>
                                            <b><?= htmlspecialchars($this->_article->getTitre()); ?></b> - <span class="likes"><?= htmlspecialchars($this->_article->getLikes()); ?> <i class="fa fa-heart"></i></span> <br> <span> <?= htmlspecialchars($this->_article->getPublication()); ?>, BY <?= htmlspecialchars($this->_article->getAuteur()); ?></span>
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
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/template/template_post.php';