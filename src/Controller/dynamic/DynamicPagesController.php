<?php
/**
 * Created by PhpStorm.
 * User: rso
 * Date: 15.05.2018
 * Time: 18:33
 */

namespace App\Controller\dynamic;

use App\Model\PostsManager;
use App\Model\UsersManager;
use App\Model\FileManager;
use Exception;


class DynamicPagesController
{
    static function refresh_posts($total)
    {
        $posts = new PostsManager();
        $posts->posts('id_article',$total,false);

        require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/';
    }
}