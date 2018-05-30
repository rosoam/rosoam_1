<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 24.05.2018
 * Time: 22:00
 */

namespace App\Controller;

class PostsController extends MainController
{

    public function delete_post($id_article,$id_utilisateur)
    {
        if($this->_security->section_active())
        {
            if( $this->_post->is_utilisateur_article($id_article,$id_utilisateur))
            {
                $this->_post->delete_article($id_article);
            }
            else
            {
                $this->controllerException("Cet article ne vous appartient pas!");
            }
        }
        else
        {
            $this->controllerException("Vous n'êtes pas connecté, vous ne pouvez pas faire cette action");
        }
    }

    public function add_post($titre_article, $auteur_article, $extrait_article, $contenu_article, $couverture_article, $tags, $categorie)
    {
        if($this->_security->section_active())
        {
            if($this->_security->check_empty([$titre_article,$auteur_article,$extrait_article,$contenu_article]))
            {
                if(isset($couverture_article) && $couverture_article['error'] == 0)
                {
                    if($couverture_article['size'] <= 2000000)
                    {
                        $infosfichier = pathinfo($couverture_article['name']);
                        $extension_fichier = $infosfichier['extension'];
                        $extensions_autorisees = ["jpg","jpeg","png","gif"];

                        if(in_array($extension_fichier, $extensions_autorisees))
                        {
                            if($this->_post->is_title_unique($titre_article))
                            {
                                if(empty($tags)){
                                    if(empty($categorie))
                                    {
                                        // les deux sont vides
                                        echo 'les deux sont vides';
                                        $this->_post->add_article($titre_article, $auteur_article,$extrait_article,$contenu_article, $this->_file->downdload_couverture_article($couverture_article),$tags, $categorie, false, false);
                                        return true;
                                    }
                                    // tags vides
                                    $this->_post->add_article($titre_article, $auteur_article,$extrait_article,$contenu_article, $this->_file->downdload_couverture_article($couverture_article),$tags, $categorie, false, true);
                                    return true;
                                }
                                else if (empty($categorie))
                                {
                                    $this->_post->add_article($titre_article, $auteur_article,$extrait_article,$contenu_article, $this->_file->downdload_couverture_article($couverture_article),$tags, $categorie, true, false);
                                }
                                else
                                {
                                    $this->_post->add_article($titre_article, $auteur_article,$extrait_article,$contenu_article, $this->_file->downdload_couverture_article($couverture_article),$tags, $categorie, true, true);
                                }
                            }
                            else
                            {
                                $this->controllerException("Désolé, un autre article possède le même titre que le vôtre, veuillez changer le titre de votre article");
                            }
                        }
                        else
                        {
                            $this->controllerException("Extension du fichier envoyé invalide");
                        }
                    }
                    else
                    {
                        $this->controllerException("Fichier trop volumineux");
                    }
                }
                else
                {
                    $this->controllerException("Erreur, avec le fichier!");
                }
            }
            else
            {
                $this->controllerException("Tous les champs ne sont pas remplis");
            }
        }
        else
        {
            $this->controllerException("Vous n'êtes pas connecté, vous ne pouvez pas faire cette action");
        }
    }
}