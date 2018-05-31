<?php
/**
 * Created by PhpStorm.
 * User: rso
 * Date: 31.05.2018
 * Time: 18:08
 */

$this->newPost($post_details->fetch(PDO::FETCH_ASSOC));
?>
<div class="modal-body">
    <form class="add-post-formulaire" id="add-post-form">
        <div class="form-row">
            <div class="form-group col-8">
                <label for="add-post-titre-article">Titre de l'article*</label>
                <input type="text" class="form-control" id="add-post-titre-article" value="<?= htmlspecialchars($this->_article->getTitre()); ?>">
            </div>
            <div class="form-group col-4">
                <label for="add-post-auteur-article">Auteur de l'article*</label>
                <input type="text" class="form-control" id="add-post-auteur-article" value="<?= htmlspecialchars($this->_article->getAuteur()); ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-8">
                <label for="add-post-extrait-article">Le teaser de votre article*</label>
                <input type="text" class="form-control" id="add-post-extrait-article" value="<?= htmlspecialchars($this->_article->getExtrait()); ?>" >
            </div>
            <div class="form-group col-4">
                <label for="post-couverture">Nouvelle image de couverture?</label>
                <input type="file" id="add-post-couverture" class="form-control inputfile" name="add-post-couverture" data-multiple-caption="{count} files selected">
            </div>
        </div>
        <div class="form-group">
            <label for="add-post-contenu-article">Votre contenu*</label>
            <textarea id="add-post-contenu-article" class="form-control" ><?= htmlspecialchars($this->_article->getContenu()); ?></textarea>
        </div>
        <!--
        <div class="modal-header">
            <h5 class="modal-title" id="modal-triggerer-title">Ajouter des tags & catégories (facultatif)</h5>
        </div>
        <div class="modal-body">
            <div class="add-post-carac" id="add-post-carac">
                <div class="row post-tags-area">
                    <div class="col-12 tags-carousel">
                        <input type="text" class="tags-item" id="tags-item" placeholder="Pour enregistrer un tag, commencez votre mot par #. Essayez!">
                        <div class="cloud-tags"></div>
                    </div>
                </div>
                <div class="row post-categories-area">
                    <div class="col-12 categories-carousel">
                        <!-- Generated -->
                        <!-- Generated -->
                        <!-- Generated -->
                        <?php/*
                        $categories = $this->_post->all_categories();
                        $fetch_categories = $categories->fetchAll();
                        foreach($fetch_categories as $categorie)
                        {
                            $this->newCategorie($categorie);
                            ?>
                            <div class="categorie-item"><p><a href="#"><?= htmlspecialchars($this->_categorie->getNom()); ?></a></p></div>
                        <?php }*/?>
                        <!-- Generated -->
                        <!-- Generated -->
                        <!-- Generated -->
                    <!--</div>
                </div>
            </div>
        </div>
        -->
        <button class="add-post-submit">Créer l'article</button>
    </form>
</div>
<?php
$post_details->closeCursor();
?>
