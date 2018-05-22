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
use App\Controller\FileController;

try
{
    $router = new App\Router\Router($_GET['url']);
    $controller = new PagesController();
    $user = new UsersController();
    $file = new FileController();

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
        // validation de l'url cliqué depuis l'email
        $controller::validate_user($id, $validation_code);
    });

    $router->get('/posts/:slug', function($slug) use ($controller) {
        $controller::post($slug);
    });

    $router->get('/file-send', function() use ($controller) {
        $controller::send_file();
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
        $controller::more_posts();
    });

    $router->post('/send-file', function() use ($file){
        $file::send_file();
    });



    $router->run();
} catch(Exception $e)
{
    echo $e->getMessage();
    header("HTTP/1.1 404 Not Found");
}

//$router->get('/posts/:id-:slug', function($id, $slug) use ($router) { echo $router->url('Posts#show', ['id' => 23, 'slug' => 'salut-les-gens']); }, 'posts.show')->with('id', '[0-9]+')->with('slug', '([a-z\-0-9]+)');
//$router->get('/posts/:id', "Posts#show");
//$router->post('/posts/:id', function($id){ echo 'Poster pour l\'article ' . $id . '<pre>' . print_r($_POST, true) . '</pre>' ; });