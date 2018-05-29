<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 28.05.2018
 * Time: 22:25
 */

namespace App\Controller;

use App\Entities\Post;
use App\Entities\Utilisateur;
use App\Entities\Tag;
use App\Entities\Categorie;

use App\Model\PostsManager;
use App\Model\FileManager;
use App\Model\SecurityManager;
use App\Model\UsersManager;
use Exception;

class MainController
{
    protected $_post;
    protected $_user;
    protected $_file;
    protected $_security;

    protected $_article;
    protected $_utilisater;
    protected $_tag;
    protected $_categorie;

    public function __construct()
    {
        $this->_post =              new PostsManager();
        $this->_user =              new UsersManager();
        $this->_file =              new FileManager();
        $this->_security =          new SecurityManager();
    }

    protected function controllerException($exception)
    {
        throw new Exception($exception);
    }
}