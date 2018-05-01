<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 16:36
 */
$post = $post_details->fetch();
$title = $post['titre_article'];

ob_start();
?>
    <p>Voici mes posts</p>
<?php
$post_details->closeCursor();
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/template.php';
