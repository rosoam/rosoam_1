<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 01.05.2018
 * Time: 20:58
 */

$title = "Subscribing page";

ob_start();
?>
    <div class="subscribe-section section">
        <div class="subscribe-content">
            <div class="container">
                <form id="inscription-form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="username">Username</label>
                                <input type="text" id="username" class="form-control" name="username" placeholder="Username" required>
                            </div>
                            <div class="col">
                                <label for="email">Email</label>
                                <input type="email" id="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="password">Mot de passe</label>
                                <input type="password" id="password" class="form-control" name="password" placeholder="Mot de passe" required>
                            </div>
                            <div class="col">
                                <label for="confirmPassword">Confirmation du mot de passe</label>
                                <input type="password" id="confirmPassword" class="form-control" name="confirmPassword" placeholder="Confirmez votre mot de passe" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <input type="submit" id="inscription-submit" class="btn btn-primary" value="S'inscrire">
                    </div>
                    <span class="inscription-statut"></span>
                </form>
            </div>
        </div>
    </div>
<?php
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/template/template_admin.php';