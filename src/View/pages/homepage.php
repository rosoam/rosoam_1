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
<section id="header-section">
    <div class="header-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Hello World, welcome to my website!</h1>
                </div>
            </div>
        </div>
    </div>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/teaser-last-news.php'; ?>
</section>
<section id="presentation" class="presentation-section section">
    <div class="presentation-content">
        <div class="container">
            <div class="row">
                <div class="col-12 presentation-title-area">
                    <h2>Welcome!</h2>
                </div>
                <div class="col-12 presentation-text-area">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean non porta libero.
                    Phasellus suscipit non turpis in tempus. Vestibulum imperdiet elit non tortor consectetur elementum.
                    Phasellus dignissim iaculis metus. Maecenas urna libero, dapibus eu neque non, pretium varius dolor.
                    Donec sollicitudin sem nibh, et mattis quam venenatis ac. Nam in libero at lacus porttitor vehicula
                    non sed lectus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis
                    egestas. Praesent porta iaculis purus. Vestibulum mattis enim eu magna auctor feugiat. Nullam
                    pellentesque, elit ut tincidunt iaculis, diam urna hendrerit quam, a dictum sapien risus sed risus.
                    Pellentesque a nibh id nibh pharetra congue euismod vel dolor. Quisque vel mattis dolor. </p>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="blog" class="blog-section section">
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-12 blog-title-area">
                    <h2>Blog</h2>
                    <a href="/posts" class="text-right">Tous les posts</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="blog-area">
                        <?php require $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/blog.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/template/template-homepage.php';
