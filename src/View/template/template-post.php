<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 01.05.2018
 * Time: 21:31
 */

ob_start();
?>
    <div id="post-page" class="content-page">
        <?= $content ?>
    </div>
<?php
$template_page_content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/base_website.php';