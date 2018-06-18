<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 16:36
 */

$title = "Error 404 - Page not found!";

ob_start();
?>
    <div class="404-section section">
        <div class="container">
            <h2>Page introuvable</h2>
            <p>Oups, il se pourrait bien que la page que vous recherchez n'existe pas!</p>
        </div>
    </div>
<?php
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/template/template_page.php';
