<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 29.04.2018
 * Time: 19:37
 */

session_start();

require 'vendor/autoload.php';

use App\Controller\PagesController;
use App\Controller\UsersController;
use App\Controller\PostsController;

try
{
    $router = new App\Router\Router($_GET['url']);
    $controller = new PagesController();
    $user = new UsersController();
    $post = new PostsController();

    $router->get('/', function() use ($controller) {
        $controller::homepage();
    });

    $router->get('/posts', function() use ($controller) {
        $controller::posts();
    });

    $router->get('/admin', function() use ($controller) {
        $controller::admin();
    });

    $router->get('/subscribe', function() use ($controller) {
        $controller::subscribe();
    });

    $router->get('/validate_user/:id/:validation_code', function($id, $validation_code) use ($controller){
        $controller::validate_user($id, $validation_code);
    });

    $router->get('/posts/:slug', function($slug) use ($controller) {
        $controller::post($slug);
    });



    $router->post('/subscribe_user', function() use ($user) {
        $user::validate_user($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm_password']);
        //$user::subscribe_user($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm_password']);
    });

    $router->post('/login_user', function() use ($user) {
        $user::login_user($_POST['username'],$_POST['password']);
    });

    $router->post('/logout', function() use ($user){
        $user::logout();
    });

    $router->post('/more_posts', function() use ($controller){
        $count = intval($_POST['count']);
        $limit = intval($_POST['limit']);
        $controller::more_posts($count,$limit);
    });

    $router->post('/auteur_posts', function() use ($controller){
       $controller::get_auteur_posts($_POST['auteur']);
    });

    $router->post('/tags_posts', function() use ($controller){
       $controller::get_tags_articles($_POST['tags']);
    });

    $router->post('/categorie_posts', function() use ($controller){
       $controller::get_categorie_articles($_POST['categorie']);
    });

    $router->post('/refresh_posts', function() use ($controller){
       $controller::refresh_all_posts();
    });

    $router->post('/refresh_personal_posts', function() use ($controller){
        $controller::refresh_personal_posts();
    });

    $router->post('/add_post', function() use ($post){
        $post::add_post($_POST['titre_article'],$_POST['auteur_article'],$_POST['extrait_article'],$_POST['contenu_article'],$_FILES['file']);
    });

    $router->post('/delete_post', function() use ($post){
        $post::delete_post($_POST['id_article'],$_SESSION['user_id']);
    });

    $router->run();
} catch(Exception $e)
{
    echo $e->getMessage();
    header("HTTP/1.1 404 Not Found");
}