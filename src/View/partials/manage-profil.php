<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 22.05.2018
 * Time: 20:46
 */
?>
<div class="public-profil-area">
    <div class="public-profil-title-area">
        <h2>Votre profil public</h2>
    </div>
    <div class="public-profil-text-area">
        <form class="update-public-profil-form" id="public-profil-form">
            <div class="row">
                <div class="col-9">
                    <div class="form-group">
                        <label for="update-name">Prénom</label>
                        <input type="text" class="form-control" id="update-name" placeholder="Prénom">
                    </div>
                    <div class="form-group">
                        <label for="update-family-name">Nom de famille</label>
                        <input type="text" class="form-control" id="update-family-name" placeholder="Nom de famille">
                    </div>
                </div>
                <div class="col-3">
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
