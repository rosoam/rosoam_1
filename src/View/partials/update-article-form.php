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
    <form class="update-post-formulaire" id="update-post-form">
        <div class="form-row">
            <div class="form-group col-8">
                <label for="update-post-titre-article">Titre de l'article*</label>
                <input type="text" class="form-control" id="update-post-titre-article" value="<?= htmlspecialchars($this->_article->getTitre()); ?>">
            </div>
            <div class="form-group col-4">
                <label for="update-post-auteur-article">Auteur de l'article*</label>
                <input type="text" class="form-control" id="update-post-auteur-article" value="<?= htmlspecialchars($this->_article->getAuteur()); ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-8">
                <label for="update-post-extrait-article">Le teaser de votre article*</label>
                <input type="text" class="form-control" id="update-post-extrait-article" value="<?= htmlspecialchars($this->_article->getExtrait()); ?>" >
            </div>
            <div class="form-group col-4">
                <label for="post-couverture">Nouvelle image de couverture?</label>
                <input type="file" id="update-post-couverture" class="form-control inputfile" name="update-post-couverture" data-multiple-caption="{count} files selected">
            </div>
        </div>
        <div class="form-group">
            <label for="update-post-contenu-article">Votre contenu*</label>
            <textarea id="update-post-contenu-article" class="form-control" ><?= htmlspecialchars($this->_article->getContenu()); ?></textarea>
        </div>

        <div class="modal-header">
            <h5 class="modal-title" id="modal-triggerer-title">Modifier les tags & catégories</h5>
        </div>
        <div class="modal-body">
            <div class="update-post-carac" id="update-post-carac">
                <div class="row post-tags-area">
                    <div class="col-12 tags-carousel">
                        <input type="text" class="update-tags-item" id="update-tags-item" placeholder="Pour enregistrer un tag, commencez votre mot par #. Essayez!">
                        <div class="update-cloud-tags">
                        <?php

                        $tags = $this->_post->tags($this->_article->getId());
                        if($tags->rowCount() > 0)
                        {?>
                            <?php $fetch_tags = $tags->fetchAll();
                            foreach($fetch_tags as $tag)
                            {
                                $this->newTag($tag);
                                ?>
                                <span class="update-tag-choose"><span class="update-tag"><?= $this->_tag->getNom(); ?></span><span class="update-tag-choose-close">&times;</span></span>
                            <?php }
                        }
                        else
                        { ?>
                            <p>Cet article n'a pas de tags</p>
                        <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row post-categories-area">
                    <div class="col-12 categories-carousel">
                        <?php

                        $categorie = $this->_post->categories($this->_article->getId());
                        if($categorie->rowCount() > 0)
                        {
                            $this->newCategorie($categorie->fetch(PDO::FETCH_ASSOC));
                            ?>
                            <p><?= $this->_categorie->getNom(); ?> <a href="#" class="change-cat">Modifier la catégorie?</a></p>
                        <?php }
                        else
                        { ?>
                            <p>Cet article n'a pas de catégories définie <a href="#" class="change-cat">Modificer la catégorie?</a></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <button class="update-post-submit" id="<?= htmlspecialchars($this->_article->getId()) ?>">Valider les modifications!</button>
    </form>
</div>
<?php
$post_details->closeCursor();
?>