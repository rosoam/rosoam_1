<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 16:36
 */

$title = "Bienvenue sur la homepage de mon site internet!";

ob_start();
?>
    <div class="404-section section">
        <div class="container">
            <h1>ERROR 404</h1>
        </div>
    </div>
<?php
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/template/template-page.php';
