<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 15:41
 */

namespace App\Controller;

use App\Model\PostsManager;
use App\Model\UsersManager;
use Exception;

class PagesController
{
    static function homepage()
    {
        $post_management = new PostsManager();
        $blog = $post_management->posts("id_article", 3, false);
        $fetch_blog = $blog->fetchAll();
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/homepage.php';
    }

    static function posts()
    {
        $post_management = new PostsManager();
        $blog = $post_management->posts("id_article", 50, false);
        $fetch_blog = $blog->fetchAll();

        $fav_blog = $post_management->posts("likes_article",3, false);

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/posts.php';
    }

    static function post($title)
    {
        $details = new PostsManager();

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/post.php';
    }

    static function admin()
    {
        $post_management = new PostsManager();

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/admin.php';
    }

    static function subscribe()
    {
        if(isset($_SESSION['username']))
        {
            header('Location: /');
            return false;
        }
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/subscribe.php';
    }

    static function validate_user($id, $validation_code)
    {
        $user = new UsersManager();

        if($user->confirm_user_validation($id, $validation_code))
        {
            $message = "Merci! Votre compte est maintenant validé!";
        }
        else
        {
            $message = "Oh Oh, un petit problème s'est déroulé, votre lien de confirmation est invalide!";
        }

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/confirm-user.php';

    }

    static function more_posts($count, $limit)
    {
        $post_management = new PostsManager();
        $blog = $post_management->posts("id_article", $limit, false);
        $fetch_blog = $blog->fetchAll();

        $number_of_article = $post_management->count_posts();

        if($count < $number_of_article)
        {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/homepage-blog.php';
        }
        else
        {
            throw new Exception("Aucun autre article enregistré");
        }
    }

    static function get_auteur_posts($auteur)
    {
        $post_management = new PostsManager();

        if($auteur === "")
        {
            $blog = $post_management->posts('id_article', 50, false);
            $fetch_blog = $blog->fetchAll();

            require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/blog.php';
        }
        else
        {
            $blog = $post_management->get_auteur_posts($auteur);
            $fetch_blog = $blog->fetchAll();
            $count = $blog->rowCount();
            if($count > 0)
            {
                require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/blog.php';
            }
            else
            {
                throw new Exception("Cet auteur n'a aucun article, veuillez essayer un nouveau nom d'auteur");
            }
        }
    }

    static function get_tags_articles($tags)
    {
        $post_management = new PostsManager();
        $blog = $post_management->get_tags_articles($tags);
        $fetch_blog = $blog->fetchAll();
        $count = $blog->rowCount();
        if($count > 0)
        {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/blog.php';
        }
        else
        {
            throw new Exception("Tag(s) sélectionné invalide!");
        }

    }

    static function get_categorie_articles($categorie)
    {
        $post_management = new PostsManager();
        $blog = $post_management->get_categorie_articles($categorie);
        $fetch_blog = $blog->fetchAll();
        $count = $blog->rowCount();

        if($count > 0)
        {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/blog.php';
        }
        else
        {
            throw new Exception("Tag(s) sélectionné invalide!");
        }
    }

    static function refresh_all_posts()
    {
        $post_management = new PostsManager();
        $blog = $post_management->posts('id_article',50,false);
        $fetch_blog = $blog->fetchAll();

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/blog.php';
    }

    static function refresh_personal_posts()
    {
        if(isset($_SESSION['username']))
        {
            $post_management = new PostsManager();

            require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/user-blog.php';
        }
        else
        {
            throw new Exception("Vous devez être connecté pour faire cette action");
        }
    }
}