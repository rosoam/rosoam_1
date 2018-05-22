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

        $post_teaser = $post_management->posts("id_article", 1, false);
        $fetch_posts_teaser = $post_teaser->fetchAll();

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/homepage.php';
    }

    static function posts()
    {
        $post_management = new PostsManager();
        $blog = $post_management->posts("id_article", 50, false);
        $fetch_blog = $blog->fetchAll();

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/posts.php';
    }

    static function post($title)
    {
        $details = new PostsManager();

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/post.php';
    }

    static function admin()
    {
        $new_posts_teaser = new PostsManager();

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

    static function send_file()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/file-send.php';
    }

    /**
     * @param $id
     * @param $validation_code
     * @throws \Exception
     */
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

    /**
     *
     */
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
}