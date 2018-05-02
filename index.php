<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 29.04.2018
 * Time: 19:37
 */

require 'vendor/autoload.php';

use App\Controller\PagesController;

try
{
    $router = new App\Router\Router($_GET['url']);
    $controller = new PagesController();

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

    $router->get('/posts/:slug', function($slug) use ($controller) {
        $controller::post($slug);

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