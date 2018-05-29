<?php
/**
 * Created by PhpStorm.
 * User: rso
 * Date: 15.05.2018
 * Time: 15:20
 */

ob_start();
?>
    <div class="confirm-user-section section">
        <div class="container">
            <p><?= $message ?> - vous pouvez vous connecter <a href="/admin">ici</a></p>
        </div>
    </div>
<?php
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/template/template-page.php';