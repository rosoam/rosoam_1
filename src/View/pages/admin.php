<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 01.05.2018
 * Time: 20:34
 */

$title = "Admin page";

ob_start();
?>
    <p>Voici la page admin</p>
<?php
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/template/template-admin.php';