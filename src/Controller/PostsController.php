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
use Exception;

class PostsController
{
    static function delete_post($id_article,$id_utilisateur)
    {
        if(isset($_SESSION['username']))
        {
            $post = new PostsManager();
            if($post->is_utilisateur_article($id_article,$id_utilisateur))
            {
                $post->delete_article($id_article);
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

    static function add_post($titre_article, $auteur_article, $extrait_article, $contenu_article, $couverture_article)
    {
        if(isset($_SESSION['username']))
        {
            $empty_fields_error = "Le(s) champ(s) suivant(s) est/sont vide(s) :";
            $error = 0;

            if(empty($titre_article))
            {
                //throw new Exception("Champs titre vide!");
                $empty_fields_error .= "titre, ";
                $error++;
            }

            if(empty($auteur_article))
            {
                //throw new Exception("Champs auteur vide!");
                $empty_fields_error .= "auteur, ";
                $error++;
            }

            if(empty($extrait_article))
            {
                //throw new Exception("Champs extrait vide!");
                $empty_fields_error .= "extrait, ";
                $error++;
            }

            if(empty($contenu_article))
            {
                //throw new Exception("Champs contenu vide!");
                $empty_fields_error .= "contenu.";
                $error++;
            }

            if($error > 0)
            {
                throw new Exception($empty_fields_error);
            }

            if(isset($couverture_article) && $couverture_article['error'] == 0)
            {
                if($couverture_article['size'] <= 1000000)
                {
                    $infosfichier = pathinfo($couverture_article['name']);
                    $extension_fichier = $infosfichier['extension'];
                    $extensions_autorisees = ["jpg","jpeg","png","gif"];

                    if(in_array($extension_fichier, $extensions_autorisees))
                    {
                        $post = new PostsManager();

                        if($post->is_title_unique($titre_article))
                        {
                            $file = new FileManager();
                            $post->add_article($titre_article, $auteur_article,$extrait_article,$contenu_article, $file->downdload_couverture_article($couverture_article));
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
            throw new Exception("Vous n'êtes pas connecté, vous ne pouvez pas faire cette action");
        }
    }
}