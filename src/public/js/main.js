$(document).ready(function() {

    var errors = 0;

    $('#inscription-submit').click(function(e) {
        e.preventDefault();

        var error_message = "Erreur les champs suivants sont vides: ";
        var $form_username = $('#inscription-form #username').val();
        var $form_email = $('#inscription-form #email').val();
        var $form_password = $('#inscription-form #password').val();
        var $form_confirmPassword = $('#inscription-form #confirmPassword').val();

        if ($form_username === "") {
            error_message += "username, ";
            errors++;
        }

        if ($form_email === "") {
            error_message += "email, ";
            errors++;
        }

        if ($form_password === "") {
            error_message += "password, ";
            errors++;
        }

        if ($form_confirmPassword === "") {
            error_message += "second password.";
            errors++;
        }

        if (errors > 0) {
            $('#modal-triggerer .modal-header h5').text("Erreur!");
            $('#modal-triggerer .modal-body').text(error_message);
            $('#modal-triggerer').modal('show');
            setTimeout(function() {
                $('#modal-triggerer').modal('hide');
            }, 3000);
        } else {
            subscribe_user($form_username, $form_email, $form_password, $form_confirmPassword);
        }
        errors = 0;
    });

    $('#connect-submit').click(function(e) {
        e.preventDefault();

        var $form_username = $('#connection-form #username').val();
        var $form_password = $('#connection-form #password').val();

        login_user($form_username, $form_password);
    });

    $('.logout').click(function(e) {
        e.preventDefault();
        logout();
    });

    $('#update-profil-picture').on('change', function() {
        readURL(this);
    });

    resizeHeader();
    resizeBlogBoxes();

    $(window).resize(function() {
        resizeBlogBoxes();
        resizeHeader();
    });

    $('.tag-item').click(function() {
        switchActiveClass($(this));
    });

    $('.categorie-item').click(function() {
        onlyActiveClass($(this));
    });

    tinymce.init({
        selector: 'textarea#add-post-contenu-article',
        plugins: "autolink",
        plugins: "link",
    });

    $(document).on('focusin', function(e) {
        if ($(e.target).closest(".mce-window").length) {
            e.stopImmediatePropagation();
        }
    });



    var frontendTags = [];

    $('.tags-item').on('change paste keyup', function(e) {
        if (e.keyCode == 32) {

            var valeurs = $(this).val();
            var arrayValeurs = valeurs.split(' ');
            var arrayLastValeur = arrayValeurs[arrayValeurs.length - 2];

            var regex = /(^#[a-zA-Z0-9_]{1,50})/g;

            var text = $('.cloud-tags').html();
            //console.log(text);

            if (arrayLastValeur.match(regex)) {
                //console.log(arrayLastValeur);

                var valToPush = arrayLastValeur.replace('#', '');
                if ($.inArray(valToPush, frontendTags) !== -1) {
                    console.log('deja dedans');
                } else {
                    frontendTags.push(valToPush);

                    var tagsLasItem = frontendTags[frontendTags.length - 1];

                    $('.cloud-tags').fadeOut(100, function() {
                        $('.cloud-tags').html(text = text + '<span class="tag-choose"> <span class="tag">' + tagsLasItem + '</span><span class="tag-choose-close">&times;</span></span>');
                    }).fadeIn(500);

                }
            }
            $(this).val('');
        }
    });

    $(document).on('click', '.tag-choose-close', function(e) {
        var text = $(this).siblings('.tag').text();

        frontendTags = $.grep(frontendTags, function(value) {
            return value != text;
        });

        $('.cloud-tags').html('');

        var cloudArea = $('.cloud-tags').html();

        for (var i = 0; i < frontendTags.length; i++) {
            $('.cloud-tags').html(cloudArea = cloudArea + '<span class="tag-choose"> <span class="tag">' + frontendTags[i] + '</span><span class="tag-choose-close">&times;</span></span>');
        }
    });

    $(document).on('click','.add-post-submit', function(e) {

        e.preventDefault();
        console.log(frontendTags);

        var titre_article = $('#add-post-titre-article').val().trim();
        var auteur_article = $('#add-post-auteur-article').val().trim();
        var extrait_article = $('#add-post-extrait-article').val().trim();
        var contenu_article = tinyMCE.activeEditor.getContent();
        var couverture_article = $('.add-post-formulaire input[type=file]')[0].files[0];

        var categories = $('.categorie-item.active').text();
        console.log(categories.length);

        var error_message = "Erreur: ";

        if (titre_article === "") {
            error_message += "titre, ";
            errors++;
        }

        if (auteur_article === "") {
            error_message += "auteur, ";
            errors++;
        }

        if (extrait_article === "") {
            error_message += "extrait, ";
            errors++;
        }

        if (contenu_article === "") {
            error_message += "contenu, ";
            errors++;
        }

        if (couverture_article === undefined) {
            error_message += "image de couverture ";
            errors++;
        }

        if (errors > 0) {
            error_message += " vide(s)!";
            $('#modal-triggerer .modal-header h5').text("Erreur!");
            $('#modal-triggerer .modal-body').text(error_message);
            $('#modal-triggerer').modal('show');
            setTimeout(function() {
                $('#modal-triggerer').modal('hide');
            }, 3000);
        } else {
            var add_post_datas = new FormData();

            add_post_datas.append('titre_article', titre_article);
            add_post_datas.append('auteur_article', auteur_article);
            add_post_datas.append('extrait_article', extrait_article);
            add_post_datas.append('contenu_article', contenu_article);
            add_post_datas.append('file', couverture_article);

            add_post_datas.append('tags', frontendTags);
            add_post_datas.append('categorie', categories);

            //alert(tags);

            add_post(add_post_datas);
        }

        // reset des erreurs si tout est bon
        errors = 0;
    });

    $(document).on('click', '.delete-post', function(e) {
        e.preventDefault();
        var article_id = parseInt($(this).attr('id'));

        delete_post(article_id);
    });

    $('.post-categorie').click(function(e) {
        e.preventDefault();

        var categorie = $(this).text();

        get_categorie_posts(categorie);
    });

    $('.tag-item,.post-categorie, .categorie-item').click(function(e) {
        e.preventDefault();
    });

    $('.get-auteur-posts').click(function(e) {
        e.preventDefault();
        var auteur = $('.auteurs-area form #auteur').val();

        auteur_posts(auteur);
    });

    $('.more-posts').click(function(e) {
        e.preventDefault();
        var count = 0;
        $('.homepage-blog .blog-post.box').each(function() {
            count++;
        });
        var newLimit = count + 4;
        more_posts(count, newLimit);

    });

    $('.tag_search').click(function(e) {
        e.preventDefault();
        var tags = [];

        $('.tag-item.active').each(function() {
            tags.push($(this).text());
        });

        if (tags.length === 0) {
            refresh_posts();
        } else {
            get_tags_articles(tags);
        }
    });

    window.sr = ScrollReveal();
    sr.reveal('.logo-ressources', {
        duration: 1000,
        delay: 200,
        origin: 'bottom'
    });

});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#test').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function resizeBlogBoxes() {
    var firstBlogPostWidth = $('.blog-post:first-of-type').width();
    var heightSecondAndThirdBlogPost = (firstBlogPostWidth / 2) - 5;
    var otherBoxesWidth = $('.blog-post:nth-of-type(4)').width();

    $('.blog-post:first-of-type').height(firstBlogPostWidth);
    $('.blog-post:nth-of-type(2), .blog-post:nth-of-type(3)').css('height', heightSecondAndThirdBlogPost);
    $('.blog-post:nth-of-type(1n+4)').height(otherBoxesWidth);
}

function resizeHeader() {
    var menuHeight = $('#menu').height();
    $('#header').css('margin-top', menuHeight);
}

function switchActiveClass(element) {
    var element = $(element);
    if (element.hasClass('active')) {
        element.removeClass('active');
    } else {
        element.addClass('active');
    }
}

function onlyActiveClass(element) {
    var element = $(element);
    var elmClass = element.attr('class');

    var elements = $('.' + elmClass);

    elements.each(function() {
        $(this).removeClass('active');
    });

    element.hasClass('active') ? element.removeClass('active') : element.addClass('active');
}