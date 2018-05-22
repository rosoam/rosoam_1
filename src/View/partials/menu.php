<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 17:58
 */
?>
<section id="menu" class="menu-section">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="menu-container container">
            <!-- warning src link -->
            <a class="navbar-brand" href="/"><img src="../src/public/img/logo_1.svg" alt="logo" class="logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <!-- Generated from specific pages! -->
                    <!-- Generated from specific pages! -->
                    <!-- Generated from specific pages! -->
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/a-propos">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/posts">Le blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contact</a>
                    </li>
                    <!-- Generated from specific pages! -->
                    <!-- Generated from specific pages! -->
                    <!-- Generated from specific pages! -->
                </ul>

                <?php if(isset($_SESSION['username']))
                {?>
                <span class="nav-item dropdown menu-dropdown-parent">
                    <img src="<?php echo isset($_SESSION['image_profil']) ? htmlspecialchars($_SESSION['image_profil']) : "https://via.placeholder.com/75x75"; ?>
" class="nav-link dropdown-toggle"  id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/admin">Page admin</a>
                        <a class="dropdown-item" href="/admin">Paramètres</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item logout" href="#">Se déconnecter</a>
                    </div>
                </span>
                <?php }
                else
                {?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">Se connecter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/subscribe">S'inscrire</a>
                    </li>
                </ul>
                <?php }?>
            </div>
        </div>
    </nav>
</section>
