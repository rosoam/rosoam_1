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

class PagesController
{
    static function homepage()
    {
        $new_posts_teaser = new PostsManager();
        //$new_posts = new PostsManager();

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/homepage.php';
    }

    static function posts()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/pages/posts.php';
    }

    static function post($title)
    {
        $details = new PostsManager();
        $post_details = $details->post($title);

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/Pages/post.php';
    }

    static function admin()
    {
        $new_posts_teaser = new PostsManager();

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/Pages/admin.php';
    }

    static function subscribe()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/Pages/subscribe.php';
    }

    static function send_file()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/Pages/file-send.php';
    }
}