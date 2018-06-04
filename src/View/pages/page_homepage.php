<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 16:36
 */

$title = "Projet Maccaud - Bienvenue!";

ob_start();
?>
    <section id="presentation" class="presentation-section section">
        <div class="presentation-container container">
            <div class="row presentation-title-area">
                <div class="col-12">
                    <h1>Welcome!</h1>
                </div>
            </div>
            <div class="row presentation-content-area">
                <div class="col-12 col-md-7">
                    <p>
                        Bienvenue sur mon projet pour le module 104! J'ai trouvé intéressant d'essayer de comprendre le fonctionnement "interne" d'un blog.
                        Ce qui m'a logiquement dirigé sur la base de création de ce mini-blog! J'espère sincèrement que vous apprécierez le travail fourni,
                        car j'y ai passé énormément de temps! En passant par la conception de base d'un projet PHP, à la conception du modèle MVC,
                        celui-ci a été spécialement conçu pour être facil d'utilisation et compréhensible pour toute personne voulant reprendre le projet!
                    </p>
                </div>
                <div class="col-12 col-md-5">
                    <img src="../src/public/img/Outer-space-knight-vector-3.png" alt="space knight 2" class="space-knight-presentation img">
                </div>
            </div>
        </div>
    </section>

    <section id="ressources" class="ressources-section section">
        <div class="ressources-container container">
            <div class="row ressources-title-area text-center">
                <div class="col-12">
                    <h2>Mes ressources</h2>
                </div>
            </div>
            <div class="row ressources-content-area">
                <div class="col-12 col-md-3">
                    <img src="../src/public/img/codepen_png.png" alt="logo code pen" class="img img-fluid logo-ressources code-pen">
                </div>
                <div class="col-12 col-md-3">
                    <img src="../src/public/img/Stack_Overflow_logo.svg" alt="logo stack overflow" class="img img-fluid logo-ressources stack-overflow">
                </div>
                <div class="col-12 col-md-3">
                    <img src="../src/public/img/codecademy_svg.svg" alt="logo codeacademy" class="img img-fluid logo-ressources codeacademy">
                </div>
                <div class="col-12 col-md-3">
                    <img src="../src/public/img/github_svg.svg" alt="logo github" class="img img-fluid logo-ressources github">
                </div>
            </div>
        </div>
    </section>

    <section id="blog" class="blog-section section">
        <div class="blog-container container">
            <div class="row blog-title-area">
                <div class="col-12">
                    <h2>Les derniers articles</h2>
                </div>
            </div>
            <div class="row blog-content-area">
                <div class="col-12">
                    <div class="blog-area homepage-blog">
                        <?php require $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/homepage-blog.php'; ?>
                    </div>
                </div>
            </div>
            <div class="row blog-more-post-area">
                <div class="col-12 text-center">
                    <a href="/posts" class="blog-button"><span>More posts!</span></a>
                </div>
            </div>
        </div>
    </section>
<?php
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/template/template_homepage.php';
