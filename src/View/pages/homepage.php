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
<section id="presentation">
    <div class="presentation-content">
        <div class="container">
            <div class="row">
                <div class="col-12 presentation-title-area">
                    <h2>Welcome!</h2>
                </div>
                <div class="col-12 presentation-text-area">
                    <p>Véritable passionné </p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/template.php';
