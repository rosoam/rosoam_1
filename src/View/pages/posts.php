<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 16:36
 */

$title = "Bienvenue sur la page des posts!";

ob_start();
?>
    <section id="posts" class="posts-section section">
        <div class="posts-container container">
            <div class="row posts-title-area">
                <div class="col-12">
                    <h2>Le blog</h2>
                </div>
            </div>
            <div class="row posts-content-area">
                <div class="col-12 col-md-10">
                    <div class="row post-tags-area">
                        <div class="col-12 tags-carousel">
                            <!-- Generated from specific pages! -->
                            <!-- Generated from specific pages! -->
                            <!-- Generated from specific pages! -->
                            <div class="tag-item"><p>tag1</p></div>
                            <div class="tag-item"><p>tag1</p></div>
                            <div class="tag-item"><p>tag1</p></div>
                            <div class="tag-item"><p>HELLO WORLD</p></div>
                            <div class="tag-item"><p>tag1</p></div>
                            <div class="tag-item"><p>THIS IS A TAG</p></div>
                            <div class="tag-item"><p>tag1</p></div>
                            <div class="tag-item"><p>HELLO WORLD</p></div>
                            <div class="tag-item"><p>tag1</p></div>
                            <div class="tag-item"><p>tag1</p></div>
                            <div class="tag-item"><p>HELLO WORLD</p></div>
                            <div class="tag-item"><p>tag1</p></div>
                            <div class="tag-item"><p>HELLO WORLD</p></div>
                            <div class="tag-item"><p>tag1</p></div>
                            <div class="tag-item"><p>tag1</p></div>
                            <div class="tag-item"><p>THIS IS A TAG</p></div>
                            <div class="tag-item"><p>tag1</p></div>
                            <div class="tag-item"><p>tag1</p></div>
                            <div class="tag-item"><p>HELLO WORLD</p></div>
                            <div class="tag-item"><p>tag1</p></div>
                            <div class="tag-item"><p>THIS IS A TAG</p></div>
                            <!-- Generated from specific pages! -->
                            <!-- Generated from specific pages! -->
                            <!-- Generated from specific pages! -->
                        </div>
                    </div>
                    <div class="all-posts">
                        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/blog.php'; ?>
                    </div>
                </div>
                <div class="col-12 col-md-2 filtres-area">
                    <div class="auteurs-area">
                        <form>
                            <h3>Auteur</h3>
                            <div class="form-row">
                                <div class="col-12 col-lg-8">
                                    <input type="text" class="form-control" placeholder="Auteur">
                                </div>
                                <div class="col-12 col-lg-4">
                                    <button type="submit" class="btn btn-primary form-control" placeholder="Look!">Look!</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr/>
                    <div class="categories-area">
                        <h3>Les catégories</h3>
                        <div class="categories">
                            <ul>
                                <!-- Generated from specific pages! -->
                                <!-- Generated from specific pages! -->
                                <!-- Generated from specific pages! -->
                                <?php
                                $categories = $post_management->all_categories();
                                foreach($categories->fetchAll() as $categorie)
                                {?>
                                    <li><?= $categorie['nom_categorie']; ?></li>
                                <?php } ?>
                                <!-- Generated from specific pages! -->
                                <!-- Generated from specific pages! -->
                                <!-- Generated from specific pages! -->
                            </ul>
                        </div>
                    </div>
                    <hr />
                    <div class="populaires-area">
                        <h3>Les articles populaires</h3>
                        <div class="populaires">
                            <!-- Generated from specific pages! -->
                            <!-- Generated from specific pages! -->
                            <!-- Generated from specific pages! -->
                            <div class="item-populaire">
                                <a href="#">
                                    <p>
                                        <b>Hello worldworldworl world worldworld</b> - <span class="likes">1232 <i class="fa fa-heart"></i></span> <br> <span>FEB 7, BY ROMARIO</span>
                                    </p>
                                </a>
                            </div>
                            <div class="item-populaire">
                                <a href="#">
                                    <p>
                                        <b>Hello worldworldworl world worldworld</b> - <span class="likes">1232 <i class="fa fa-heart"></i></span> <br> <span>FEB 7, BY ROMARIO</span>
                                    </p>
                                </a>
                            </div>
                            <div class="item-populaire">
                                <a href="#">
                                    <p>
                                        <b>Hello worldworldworl world worldworld</b> - <span class="likes">1232 <i class="fa fa-heart"></i></span> <br> <span>FEB 7, BY ROMARIO</span>
                                    </p>
                                </a>
                            </div>
                        </div>
                        <!-- Generated from specific pages! -->
                        <!-- Generated from specific pages! -->
                        <!-- Generated from specific pages! -->
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$content = ob_get_clean();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/template/template-post.php';