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
            <div class="row">
                <div class="col-3">
                    <p>col 3</p>
                </div>
                <div class="col-9">
                    <p>col 9</p>
                    <div class="public-profil-area">
                        <div class="public-profil-title-area">
                            <h2>Votre profil public</h2>
                        </div>
                        <div class="public-profil-text-area">
                            <form class="update-public-profil-form" id="public-profil-form">
                                <div class="row">
                                    <div class="col-8">
                                        <p>col 8</p>
                                        <div class="form-group">
                                            <label for="update-name">Prénom</label>
                                            <input type="text" class="form-control" id="update-name" placeholder="Prénom">
                                        </div>
                                        <div class="form-group">
                                            <label for="update-family-name">Nom de famille</label>
                                            <input type="text" class="form-control" id="update-family-name" placeholder="Nom de famille">
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-8">
                                                <label for="update-adresse">Adresse</label>
                                                <input type="text" class="form-control" id="update-adresse" placeholder="Adresse">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="update-npa">NPA</label>
                                                <input type="password" class="form-control" id="update-npa" placeholder="Numéro postal">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="update-country">Pays</label>
                                            <input type="text" class="form-control" id="update-country" placeholder="Pays">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group update-profil-picture-zone">
                                            <label for="update-profil-picture">
                                                <span>Photo de profil</span>
                                                <img src="/src/public/uploads/binaire_hexa.png" id="test">
                                            </label>
                                            <input type="file" class="form-control" id="update-profil-picture">
                                            <p class="update-profil-picture-spec">
                                                <strong>Taille conseillée :</strong> 400x400px
                                            </p>
                                            <p class="update-profil-picture-spec">
                                                <strong>Format de fichiers :</strong> jpg, jpeg, png, gif!
                                            </p>
                                            <p class="update-profil-picture-spec">
                                                <strong>Taille max:</strong> 1MB!
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="container">
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/user-blog.php'; ?>
        </div> -->
    </div>
    <?php } ?>
<?php
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/template/template-admin.php';