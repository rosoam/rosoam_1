<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 15:41
 */

namespace App\Controller;

class PagesController extends MainController
{

    public function homepage()
    {
        $blog = $this->_post->posts("id_article", 3, false);
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/page_homepage.php';
    }

    public function posts()
    {
        $blog = $this->_post->posts("id_article",50,false);
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/page_posts.php';
    }

    public function post($title)
    {
        $post_details = $this->_post->post($title);

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/page_post.php';
    }

    public function admin()
    {
        $blog = $this->_post->posts('id_article',50,true);

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/page_admin.php';
    }

    public function subscribe()
    {
        if($this->_security->section_active())
        {
            header('Location: /');
            return false;
        }
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/page_subscribe.php';
    }

    public function validate_user($id, $validation_code)
    {
        if($this->_user->confirm_user_validation($id,$validation_code))
        {
            $message = "Merci! Votre compte est maintenant validé!";
        }
        else
        {
            $message = "Oh Oh, un petit problème s'est déroulé, votre lien de confirmation est invalide!";
        }

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/page_confirm-user.php';

    }

    public function more_posts($count, $limit)
    {
        $blog = $this->_post->posts("id_article", $limit, false);

        if($count < $this->_post->count_posts())
        {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/homepage-blog.php';
        }
        else
        {
            $this->controllerException("Aucun autre article enregistré");
        }
    }

    public function get_auteur_posts($auteur)
    {
        if($auteur === "")
        {
            $blog = $this->_post->posts("id_article",50,false);

            require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/blog.php';
        }
        else
        {
            $blog = $this->_post->get_auteur_posts($auteur);

            if($blog->rowCount() > 0)
            {
                require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/blog.php';
            }
            else
            {
                $this->controllerException("Cet auteur n'a aucun article, veuillez essayer un nouveau nom d'auteur");
            }
        }
    }

    public function get_post_to_update($id_post, $id_utilisateur)
    {
        if($this->_security->section_active())
        {
            if(!empty($id_post))
            {
                if($this->_post->is_utilisateur_article($id_post, $id_utilisateur))
                {
                    $post_details = $this->_post->post_by_id($id_post);

                    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/update-article-form.php';
                }
                else
                {
                    $this->controllerException("Cet article ne vous appartient pas, vous ne pouvez pas faire ça!");
                }
            }
            else
            {
                $this->controllerException("Aucun id envoyé, veuillez vérifier les informations du post sélectionné");
            }
        }
        else
        {
            $this->controllerException("Vous n'êtes pas connecté, vous ne pouvez pas faire cette action");
        }
    }

    public function get_tags_articles($tags)
    {
        $blog = $this->_post->get_tags_articles($tags);

        if($blog->rowCount() > 0)
        {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/blog.php';
        }
        else
        {
            $this->controllerException("Tag(s) sélectionné invalide!");
        }
    }

    public function get_categorie_articles($categorie)
    {
        $blog = $this->_post->get_categorie_articles($categorie);

        if($blog->rowCount() > 0)
        {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/blog.php';
        }
        else
        {
            $this->controllerException("Tag(s) sélectionné invalide!");
        }
    }

    public function refresh_all_posts()
    {
        $blog = $this->_post->posts('id_article',50,false);

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/blog.php';
    }

    public function refresh_personal_posts()
    {
        if($this->_security->section_active())
        {
            $blog = $this->_post->posts('id_article', 5, true);

            require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/user-blog.php';
        }
        else
        {
            $this->controllerException("Vous devez être connecté pour faire cette action");
        }
    }
}