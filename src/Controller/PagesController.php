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
        $posts_teaser = new PostsManager();
        $posts = new PostsManager();

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
}