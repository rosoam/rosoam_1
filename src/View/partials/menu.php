<?php
/**
 * Created by PhpStorm.
 * User: romar
 * Date: 30.04.2018
 * Time: 17:58
 */
?>
<section id="menu-section">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/"><img alt="logo du site" class="logo" src="https://via.placeholder.com/200x70.png"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/a-propos">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/posts">les posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Prenez-contact</a>
                    </li>
                </ul>
                <?php if(isset($_SESSION['username']))
                { ?>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="https://res.cloudinary.com/rosoam/image/upload/v1520204756/romario_profil.png" alt="user image" class="user-img">
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="/admin">Admin page</a>
                                <a class="dropdown-item logout" href="#">Se déconnecter</a>
                            </div>
                        </li>
                    </ul>
                <?php } else
                { ?>
                    <a href="/admin/">Login</a> - <a href="/subscribe/">Sign in</a>
                <?php }?>
            </div>
        </nav>
    </div>
</section>
