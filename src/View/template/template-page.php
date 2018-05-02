<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 01.05.2018
 * Time: 21:24
 */

ob_start();
?>
    <div id="basic-page" class="content-page">
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
        </section>
        <?= $content ?>
    </div>
<?php
$style_page_content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/base_website.php';