$(document).ready(function() {

    // GLOBAL

    // prevent default de button / a et autres.
    $('.tag-item,.post-categorie, .categorie-item').click(function(e) {
        e.preventDefault();
    });

    window.sr = ScrollReveal();
    sr.reveal('.logo-ressources', {
        duration: 1000,
        delay: 200,
        origin: 'bottom'
    });

    resizeHeader();
    resizeBlogBoxes();

    $(window).resize(function() {
        resizeBlogBoxes();
        resizeHeader();
    });

    $('.categorie-item').click(function() {
        onlyActiveClass($(this));
    });

    $('.tag-item').click(function() {
        $(this).toggleClass('active');
    });

    // HOMEPAGE

    // Fonction pour load + d'article dans la homepage
    $('.more-posts').click(function(e) {
        e.preventDefault();
        var count = 0;
        $('.homepage-blog .blog-post.box').each(function() {
            count++;
        });
        var newLimit = count + 4;
        more_posts(count, newLimit);

    });


    // USER FONCTIONS

    var errors = 0;

    // Fonction qui inscrit un utilisateur
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

    // Fonction qui connecte un utilisateur enregistré
    $('#connect-submit').click(function(e) {
        e.preventDefault();

        var $form_username = $('#connection-form #username').val();
        var $form_password = $('#connection-form #password').val();

        login_user($form_username, $form_password);
    });

    // Fonction logout lorsque l'utilisateur se déconnecte
    $('.logout').click(function(e) {
        e.preventDefault();
        logout();
    });

    /*
    * Inutile pour le moment
    $('#update-profil-picture').on('change', function() {
        readURL(this);
    });
    */


    //ADMIN PAGE

    // Fonction qui permet de delete un post via son id
    $(document).on('click', '.delete-post', function(e) {
        e.preventDefault();
        var article_id = parseInt($(this).attr('id'));

        delete_post(article_id);
    });

    // Fait apparaitre le formulaire pour add un article
    $(document).on('click', '.add-posts', function(e) {
        tinymceAddForm();
    });

    // Fonction add d'un article !
    $(document).on('click', '.add-post-submit', function(e) {

        e.preventDefault();

        var titre_article = $('#add-post-titre-article').val().trim();
        var auteur_article = $('#add-post-auteur-article').val().trim();
        var extrait_article = $('#add-post-extrait-article').val().trim();
        var contenu_article = tinyMCE.activeEditor.getContent();
        var couverture_article = $('.add-post-formulaire input[type=file]')[0].files[0];

        var categories = $('.categorie-item.active').text();

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



    /*
    FONCTION DE CREATION DE TAGS DANS LE FORMULAIRE D'AJOUT D'ARTICLE
     */
    var frontendTags = [];

    $('.tags-item').on('change paste keyup', function(e) {
        if (e.keyCode == 32) {

            var valeurs = $(this).val();
            var arrayValeurs = valeurs.split(' ');
            var arrayLastValeur = arrayValeurs[arrayValeurs.length - 2];

            var regex = /(^#[a-zA-Z0-9_]{1,50})/g;

            var text = $('.cloud-tags').html();

            if (arrayLastValeur.match(regex)) {

                var valToPush = arrayLastValeur.replace('#', '');
                if ($.inArray(valToPush, frontendTags) !== -1) {} else {
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
    /*
    FONCTION DE CREATION DE TAGS DANS LE FORMULAIRE D'AJOUT D'ARTICLE END
    */


    // Fonction qui load le formulaire correspondant au post selectionné
    $(document).on('click', '.update-post', function(e) {
        e.preventDefault();
        var article_id = parseInt($(this).attr('id'));

        get_update_form(article_id);
    });


    $(document).on('change paste keyup','.update-tags-item',function(e){
        if (e.keyCode == 32) {
            var valeurs = $(this).val();
            var arrayValeurs = valeurs.split(' ');
            var arrayLastValeur = arrayValeurs[arrayValeurs.length - 2];

            var regex = /(^#[a-zA-Z0-9_]{1,50})/g;

            var text = $('.update-cloud-tags').html();

            if (arrayLastValeur.match(regex)) {

                var valToPush = arrayLastValeur.replace('#', '');
                if ($.inArray(valToPush, frontendTagsUpdate) !== -1) {} else {
                    frontendTagsUpdate.push(valToPush);

                    var tagsLasItem = frontendTagsUpdate[frontendTagsUpdate.length - 1];

                    $('.update-cloud-tags').fadeOut(100, function() {
                        $('.update-cloud-tags').html(text = text + '<span class="update-tag-choose"> <span class="update-tag">' + tagsLasItem + '</span><span class="update-tag-choose-close">&times;</span></span>');
                    }).fadeIn(500);

                }
            }
            $(this).val('');
        }
    });

    $(document).on('click', '.update-tag-choose-close', function(e) {
        var text = $(this).siblings('.update-tag').text();

        frontendTagsUpdate = $.grep(frontendTagsUpdate, function(value) {
            return value != text;
        });

        $('.update-cloud-tags').html('');

        var cloudArea = $('.update-cloud-tags').html();

        for (var i = 0; i < frontendTagsUpdate.length; i++) {
            $('.update-cloud-tags').html(cloudArea = cloudArea + '<span class="update-tag-choose"> <span class="update-tag">' + frontendTagsUpdate[i] + '</span><span class="update-tag-choose-close">&times;</span></span>');
        }
    });

    $(document).on('click','.update-post-submit', function(e){
        var update_post_datas = new FormData();

        e.preventDefault();
        let id_article = parseInt(this.id);
        let titre_article = $('#update-post-titre-article').val();
        let auteur_article = $('#update-post-auteur-article').val();
        let extrait_article = $('#update-post-extrait-article').val();
        let contenu_article = tinyMCE.activeEditor.getContent();
        let couverture_article = $('.update-post-formulaire .inputfile')[0].files[0];

        let tags = frontendTagsUpdate;
        let nom_categorie = $('.update-choose-categorie').text();

        update_post_datas.append('id_article',id_article);
        update_post_datas.append('titre_article',titre_article);
        update_post_datas.append('auteur_article',auteur_article);
        update_post_datas.append('extrait_article',extrait_article);
        update_post_datas.append('contenu_article',contenu_article);
        update_post_datas.append('couverture_article',couverture_article);

        update_post_datas.append('tags',tags);
        update_post_datas.append('nom_categorie',nom_categorie);

        update_post(update_post_datas);
    });

    function check(id_article,nom_categorie)
    {
        $.ajax({
            url: '/check',
            type: 'POST',
            data: {
                id_article: id_article,
                nom_categorie: nom_categorie
            },
            success: function (data) {
                alert(data);
            },
            error: function (xhr, textStatus) {
                $('#modal-triggerer .modal-header h5').text("Erreur!");
                $('#modal-triggerer .modal-body').text('not ok');
                $('#modal-triggerer').modal('show');
                setTimeout(function () {
                    $('#modal-triggerer').modal('hide');
                }, 3000);
            }
        });
    }


    // PAGE DES POSTS

    // Fonction qui permet de filtrer les articles via la catégorie sélectionnée
    $('.post-categorie').click(function(e) {
        e.preventDefault();

        var categorie = $(this).text();

        get_categorie_posts(categorie);
    });

    // Fonction qui permet de filtrer les articles via l'auteur entré dans l'input
    $('.get-auteur-posts').click(function(e) {
        e.preventDefault();
        var auteur = $('.auteurs-area form #auteur').val();

        auteur_posts(auteur);
    });

    // function qui reset les filtres et refresh tous les posts
    $('.refresh_blog').on('click', function(e) {
        e.preventDefault();

        refresh_posts();
    });

    // test string length
    crop_text($('.the-blog .blog-blog-post-body h3'), 62);
    crop_text($('.user-blog .blog-blog-post-body h3'),100);

});

function crop_text(elmt,maxlength)
{
    $(elmt).each(function(){
        if($(this).text().length > maxlength)
        {
            $(this).text($(this).text().substring(0,maxlength) + "...");
        }
    });
}

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

function onlyActiveClass(element) {
    var element = $(element);
    var elmClass = element.attr('class');

    var elements = $('.' + elmClass);

    elements.each(function() {
        $(this).removeClass('active');
    });

    element.hasClass('active') ? element.removeClass('active') : element.addClass('active');
}

function tinymceUpdateForm() {
    tinymce.remove(); // nous avons besoin de cette fonction car le textarea demandé est généré via ajax
    tinymce.init({
        selector: 'textarea#update-post-contenu-article',
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste imagetools wordcount"
        ],
        toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        theme: "modern",
        width: "100%",
        height: 300,
    });

    $(document).on('focusin', function(e) {
        if ($(e.target).closest(".mce-window").length) {
            e.stopImmediatePropagation();
        }
    });
}

function tinymceAddForm() {
    tinymce.remove();
    tinymce.init({
        selector: 'textarea#add-post-contenu-article',
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste imagetools wordcount"
        ],
        toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        menubar: "insert",
        theme: "modern",
        width: "100%",
        height: 300,
    });

    $(document).on('focusin', function(e) {
        if ($(e.target).closest(".mce-window").length) {
            e.stopImmediatePropagation();
        }
    });
}