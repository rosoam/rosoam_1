<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 01.05.2018
 * Time: 20:34
 */

$title = "Admin page";

ob_start();
?>
    <?php if(!isset($_SESSION['username']))
    { ?>
    <div class="connection-section section">
        <div class="connection-content">
            <div class="container">
                <form id="connection-form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="username">Username</label>
                                <input type="text" id="username" class="form-control" name="username" placeholder="Username ou email" required>
                            </div>
                            <div class="col">
                                <label for="password">Mot de passe</label>
                                <input type="password" id="password" class="form-control" name="password" placeholder="Mot de passe" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <input type="submit" id="connect-submit" class="btn btn-primary" value="Se connecter">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php } else { ?>
    <div class="admin-section section">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <h2>Votre espace</h2>
                    <div class="admin-menu-area">
                        <ul class="admin-menu">
                            <li class="admin-menu-item">
                                <a href="#" class="admin-menu-link-item">
                                    Page d'administration
                                </a>
                            </li>
                            <li class="admin-menu-item">
                                <a href="#" class="admin-menu-link-item">
                                    Gérer vos articles
                                </a>
                            </li>
                            <li class="admin-menu-item">
                                <a href="#" class="admin-menu-link-item">
                                    Gérer votre profil
                                </a>
                            </li>
                            <li class="admin-menu-item">
                                <a href="#" class="admin-menu-link-item">
                                    Changer votre mot de passe
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-9 admin-main-area">
                    <?php //require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/manage-profil.php'; ?>

                    <div class="modal fade" id="add-article-modal" tabindex="-1" role="dialog" aria-labelledby="add-article-modal" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal-triggerer-title">Créer un article</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="add-post-formulaire" id="add-post-form">
                                        <div class="form-row">
                                            <div class="form-group col-8">
                                                <label for="add-post-titre-article">Titre de l'article*</label>
                                                <input type="text" class="form-control" id="add-post-titre-article" placeholder="Titre de l'article">
                                            </div>
                                            <div class="form-group col-4">
                                                <label for="add-post-auteur-article">Auteur de l'article*</label>
                                                <input type="text" class="form-control" id="add-post-auteur-article" placeholder="L'auteur de cet article" value="<?= $_SESSION['username']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-8">
                                                <label for="add-post-extrait-article">Le teaser de votre article*</label>
                                                <input type="text" class="form-control" id="add-post-extrait-article" placeholder="Cet article est vraiment génial, il ne faut pas le rater!">
                                            </div>
                                            <div class="form-group col-4">
                                                <label for="post-couverture">Image de couverture</label>
                                                <input type="file" id="add-post-couverture" class="form-control inputfile" name="add-post-couverture" data-multiple-caption="{count} files selected">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="add-post-contenu-article">Votre contenu*</label>
                                            <textarea id="add-post-contenu-article" class="form-control" ></textarea>
                                        </div>
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modal-triggerer-title">Ajouter des tags & catégories (facultatif)</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="add-post-carac" id="add-post-carac">
                                                <div class="row post-tags-area">
                                                    <div class="col-12 tags-carousel">
                                                        <!-- Generated -->
                                                        <!-- Generated -->
                                                        <!-- Generated -->
                                                        <?php
                                                        $tags = $this->_post->all_tags();
                                                        $fetch_tags = $tags->fetchAll();
                                                        foreach($fetch_tags as $tag)
                                                        {
                                                            $this->newTag($tag);
                                                            ?>
                                                            <div class="tag-item"><p><a href="#"><?= htmlspecialchars($this->_tag->getNom()); ?></a></p></div>
                                                        <?php }?>
                                                        <!-- Generated -->
                                                        <!-- Generated -->
                                                        <!-- Generated -->
                                                    </div>
                                                </div>
                                                <div class="row post-categories-area">
                                                    <div class="col-12 categories-carousel">
                                                        <!-- Generated -->
                                                        <!-- Generated -->
                                                        <!-- Generated -->
                                                        <?php
                                                        $categories = $this->_post->all_categories();
                                                        $fetch_categories = $categories->fetchAll();
                                                        foreach($fetch_categories as $categorie)
                                                        {
                                                            $this->newCategorie($categorie);
                                                            ?>
                                                            <div class="categorie-item"><p><a href="#"><?= htmlspecialchars($this->_categorie->getNom()); ?></a></p></div>
                                                        <?php }?>
                                                        <!-- Generated -->
                                                        <!-- Generated -->
                                                        <!-- Generated -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="add-post-submit">Créer l'article</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row manage-articles-title-area">
                        <div class="col-12">
                            <h2>Managez vos articles!</h2>
                        </div>
                    </div>
                    <div class="row manage-articles-content-area">
                        <div class="col-12 user-articles-zone">
                            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/user-blog.php'; ?>
                        </div>
                        <div class="col-12 add-article-area">
                            <div class="add-article-zone">
                                <a href="#" class="add-posts" data-toggle="modal" data-target="#add-article-modal" ><span>Créer un article?</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
<?php
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/template/template_admin.php';