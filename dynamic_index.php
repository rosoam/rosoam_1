<?php
/**
 * Created by PhpStorm.
 * User: rso
 * Date: 15.05.2018
 * Time: 17:53
 */

session_start();

require 'vendor/autoload.php';

use App\Controller\dynamic\DynamicPagesController;

try
{
    $router = new App\Router\Router($_GET['url']);
    $controller = new DynamicPagesController();

    $router->post('/refresh-posts', function() use ($controller) {

    });

    $router->run();
} catch(Exception $e)
{
    echo $e->getMessage();
    header("HTTP/1.1 404 Not Found");
}
