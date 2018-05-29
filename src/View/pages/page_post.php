<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 16:36
 */

use App\Entities\Post;

$post = new Post($post_details->fetch(PDO::FETCH_ASSOC));
ob_start();
?>
    <div class="post-section section">
        <div class="post-container container">
            <div class="post-couverture-area row">
                <div class="col-12 post-couverture-zone">
                    <img src="<?php
                    if ($post->getCouverture() === "") {
                        echo "https://via.placeholder.com/800x600.png?text=BLOG";
                    } else {
                        echo htmlspecialchars($post->getCouverture());
                    };
                    ?>" class="post-couverture">
                </div>
            </div>
            <div class="post-title-area row">
                <div class="col-12">
                    <h2><?= htmlspecialchars($post->getTitre()) ?></h2>
                </div>
            </div>
            <div class="post-extrait-area row">
                <div class="col-12">
                    <p><b><?= htmlspecialchars($post->getExtrait()) ?></b></p>
                </div>
            </div>
            <div class="post-contenu-area row">
                <div class="col-12">
                    <?= htmlspecialchars_decode($post->getContenu()); ?>
                </div>
            </div>
        </div>
    </div>
<?php
$post_details->closeCursor();
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/template/template_post.php';