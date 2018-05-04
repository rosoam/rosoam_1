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
    <?php if(!isset($_SESSION['username']))
    { ?>
    <div class="connection-section section">
        <div class="connection-content">
            <div class="container">
                <form id="connection-form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="username">Username</label>
                                <input type="text" id="username" class="form-control" name="username" placeholder="Username ou email" required>
                            </div>
                            <div class="col">
                                <label for="password">Mot de passe</label>
                                <input type="password" id="password" class="form-control" name="password" placeholder="Mot de passe" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <input type="submit" id="connect-submit" class="btn btn-primary" value="Se connecter">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php } else { ?>
    <div class="admin-section section">
        <div class="container">
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/user-blog.php'; ?>
        </div>
    </div>
    <?php } ?>
<?php
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/template/template-admin.php';