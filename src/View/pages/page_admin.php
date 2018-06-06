<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 01.05.2018
 * Time: 20:34
 */

$title = isset($_SESSION['username']) ? "Projet Maccaud - Page d'administration" : "Projet Maccaud - Page de connection";

ob_start();
?>
    <?php if(!isset($_SESSION['username']))
    { ?>
    <div class="connection-section section">
        <div class="connection-content">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>Bonjour M. Maccaud!</h2>
                        <p>Voici les 2 comptes enregistrés prêts pour vous et vos tests!</p>
                        <p>
                            <b>Utilisateur 1:</b> <br>
                            username : <span style="color:red;">rom</span> <br>
                            mot de passe : <span style="color:red;">rom</span>
                        </p>
                        <p>
                            <b>Utilisateur 2:</b> <br>
                            username : <span style="color:red;">romario</span> <br>
                            mot de passe : <span style="color:red;">romario</span>
                        </p>
                        <p><b>Vous pouvez bien évidemment vous amusez à créer votre propre compte et vos propres articles! Essayez! L'inscription est rapide, n'oubliez pas de donner une adresse mail valide.. ^^ <a href="/subscribe" style="color:brown">INSCRIPTION ICI :)</a></b></p>
                    </div>
                </div>
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
                <div class="col-12 admin-main-area">
                    <?php //require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/manage-profil.php'; ?>
                    <!-- update-article-modal -->
                    <div class="modal fade" id="update-article-modal" tabindex="-1" role="dialog" aria-labelledby="update-article-modal" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal-triggerer-title">Modifier un article</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="update-form-container">
                                </div>
                            </div>
                        </div>
                    </div>

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
                                        <div class="row post-categories-area">
                                            <div class="col-12 categories-carousel">
                                                <p class="categories-title">Choisir la catégorie de votre article*</p>
                                                <?php
                                                $categories = $this->_post->all_categories();
                                                $fetch_categories = $categories->fetchAll();
                                                foreach($fetch_categories as $categorie)
                                                {
                                                    $this->newCategorie($categorie);
                                                    ?>
                                                    <div class="categorie-item"><p><a href="#"><?= htmlspecialchars($this->_categorie->getNom()); ?></a></p></div>
                                                <?php }?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="add-post-contenu-article">Votre contenu*</label>
                                            <textarea id="add-post-contenu-article" class="form-control" ></textarea>
                                        </div>
                                        <div class="add-post-unecessary-header">
                                            <h5 class="add-post-unecessary-title">Ajouter des tags & catégories (facultatif)</h5>
                                        </div>
                                        <div class="add-post-unecessary-body">
                                            <div class="add-post-carac" id="add-post-carac">
                                                <div class="row post-tags-area">
                                                    <div class="col-12 tags-carousel">
                                                        <p class="tags-description">Les tags nous aides à classer vos articles par thème. Plus vous mettrez de tags, plus il sera facil pour nous de trouver d'autres articles correspondant à vos critères!</p>
                                                        <input type="text" class="tags-item" id="tags-item" placeholder="Pour enregistrer un tag, commencez votre mot par # et terminez le en appuyant sur ESPACE. Essayez!">
                                                        <div class="cloud-tags"></div>
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
                                <a href="#" class="blog-button add-posts" data-toggle="modal" data-target="#add-article-modal" ><span>Créer un article?</span></a>
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