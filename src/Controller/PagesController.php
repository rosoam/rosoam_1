<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 15:41
 */

namespace App\Controller;

use App\Model\SecurityManager;
use App\Model\PostsManager;
use App\Model\UsersManager;
use Exception;

class PagesController
{

    private $_post;
    private $_user;
    private $_security;

    public function __construct()
    {
        $this->_post = new PostsManager();
        $this->_user = new UsersManager();
        $this->_security = new SecurityManager();
    }

    public function homepage()
    {
        $blog = $this->_post->posts("id_article", 3, false);
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/homepage.php';
    }

    public function posts()
    {
        $blog = $this->_post->posts("id_article",50,false);
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/posts.php';
    }

    public function post($title)
    {
        $post_details = $this->_post->post($title);

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/post.php';
    }

    public function admin()
    {
        $blog = $this->_post->posts('id_article',50,true);

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/admin.php';
    }

    public function subscribe()
    {
        if(!$this->_security->section_active())
        {
            header('Location: /');
            return false;
        }
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/subscribe.php';
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

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/confirm-user.php';

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
            throw new Exception("Aucun autre article enregistré");
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
                throw new Exception("Cet auteur n'a aucun article, veuillez essayer un nouveau nom d'auteur");
            }
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
            throw new Exception("Tag(s) sélectionné invalide!");
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
            throw new Exception("Tag(s) sélectionné invalide!");
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
            throw new Exception("Vous devez être connecté pour faire cette action");
        }
    }
}