<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 24.05.2018
 * Time: 22:00
 */

namespace App\Controller;

use App\Model\FileManager;
use App\Model\PostsManager;
use App\Model\SecurityManager;
use Exception;

class PostsController
{

    private $_file;
    private $_post;
    private $_security;

    public function __construct()
    {
        $this->_file = new FileManager();
        $this->_post = new PostsManager();
        $this->_security = new SecurityManager();
    }

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
                throw new Exception("Cet article ne vous appartient pas!");
            }
        }
        else
        {
            throw new Exception("Vous n'êtes pas connecté, vous ne pouvez pas faire cette action");
        }
    }

    public function add_post($titre_article, $auteur_article, $extrait_article, $contenu_article, $couverture_article)
    {
        if($this->_security->section_active())
        {
            if($this->_security->check_empty($_POST))
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
                                $this->_post->add_article($titre_article, $auteur_article,$extrait_article,$contenu_article, $this->_file->downdload_couverture_article($couverture_article));
                            }
                            else
                            {
                                throw new Exception("Désolé, un autre article possède le même titre que le vôtre, veuillez changer le titre de votre article");
                            }
                        }
                        else
                        {
                            throw new Exception("Extension du fichier envoyé invalide");
                        }
                    }
                    else
                    {
                        throw new Exception("Fichier trop volumineux");
                    }
                }
                else
                {
                    throw new Exception("Erreur, avec le fichier!");
                }
            }
            else
            {
                throw new Exception("Tous les champs ne sont pas remplis");
            }
        }
        else
        {
            throw new Exception("Vous n'êtes pas connecté, vous ne pouvez pas faire cette action");
        }
    }
}