/*
    -- -- -- -- user fonctions -- -- -- --
    -- -- -- -- user fonctions -- -- -- --
    -- -- -- -- user fonctions -- -- -- --
 */
function subscribe_user(username, email, password, confirm_password) {
    $.ajax({
        url: '/subscribe_user/',
        dataType: 'html',
        type: 'POST',
        data: {
            username: username,
            email: email,
            password: password,
            confirm_password: confirm_password
        },
        success: function (data) {
            $('.modal-header h5').text("Succès!");
            $('.modal-body').text("Merci, vérifiez vos mails afin de valider votre compte!");
            $('#modal-triggerer').modal('show');
            setTimeout(function () {
                $('#modal-triggerer').modal('hide');
            }, 3000);
        },
        error: function (xhr, textStatus) {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function () {
                $('#modal-triggerer').modal('hide');
            }, 3000);
        }
    });
}

function login_user(username, password) {
    $.ajax({
        url: '/login_user/',
        dataType: 'html',
        type: 'POST',
        data: {
            username: username,
            password: password
        },
        success: function (data) {
            location.reload();
        },
        error: function (xhr, textStatus) {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function () {
                $('#modal-triggerer').modal('hide');
            }, 3000);
        }
    });
}

function logout() {
    $.ajax({
        url: '/logout/',
        dataType: 'html',
        type: 'POST',
        success: function (data) {
            location.reload();
        },
        error: function (xhr, textStatus) {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function () {
                $('#modal-triggerer').modal('hide');
            }, 3000);
        }
    });
}

/*
    -- -- -- -- posts fonctions -- -- -- --
    -- -- -- -- posts fonctions -- -- -- --
    -- -- -- -- posts fonctions -- -- -- --
 */

function more_posts(count, limit) {
    $.ajax({
        url: '/more_posts',
        type: 'POST',
        dataType: 'html',
        data: {
            count: count,
            limit: limit
        },
        success: function (data) {
            $('.homepage-blog').fadeOut(300, function () {
                $('.homepage-blog').html(data);
            }).fadeIn();
        },
        error: function (xhr, textStatus) {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function () {
                $('#modal-triggerer').modal('hide');
            }, 3000);
        }
    });
}

function auteur_posts(auteur) {
    $.ajax({
        url: '/auteur_posts',
        type: 'POST',
        dataType: 'html',
        data: {
            auteur: auteur
        },
        success: function (data) {
            $('.all-posts.the-blog').fadeOut(300, function () {
                $('.all-posts.the-blog').html(data);
            }).fadeIn();
        },
        error: function (xhr, textStatus) {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function () {
                $('#modal-triggerer').modal('hide');
            }, 3000);
        }
    });
}

function get_tags_articles(tags) {
    $.ajax({
        url: '/tags_posts',
        type: 'POST',
        dataType: 'html',
        data: {
            tags: tags
        },
        success: function (data) {
            $('.all-posts.the-blog').fadeOut(300, function () {
                $('.all-posts.the-blog').html(data);
            }).fadeIn();
        },
        error: function (xhr, textStatus) {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function () {
                $('#modal-triggerer').modal('hide');
            }, 3000);
        }
    });
}

function get_categorie_posts(categorie) {
    $.ajax({
        url: '/categorie_posts',
        type: 'POST',
        dataType: 'html',
        data: {
            categorie: categorie
        },
        success: function (data) {
            $('.all-posts.the-blog').fadeOut(300, function () {
                $('.all-posts.the-blog').html(data);
            }).fadeIn();
        },
        error: function (xhr, textStatus) {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function () {
                $('#modal-triggerer').modal('hide');
            }, 3000);
        }
    });
}

function add_post(add_post_datas) {
    $.ajax({
        url: '/add_post',
        type: 'POST',
        data: add_post_datas,
        success: function (data) {
            /*$('#add-article-modal').modal('hide');
            refresh_personal_posts();*/

            $('#modal-triggerer .modal-header h5').text("Erreur!");
            $('#modal-triggerer .modal-body').text(data);
            $('#modal-triggerer').modal('show');
            setTimeout(function () {
                $('#modal-triggerer').modal('hide');
            }, 3000);
        },
        cache: false,
        contentType: false,
        processData: false,
        error: function (xhr, textStatus) {
            $('#modal-triggerer .modal-header h5').text("Erreur!");
            $('#modal-triggerer .modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function () {
                $('#modal-triggerer').modal('hide');
            }, 3000);
        }
    });
}

function delete_post(id_article) {
    $.ajax({
        url: '/delete_post',
        type: 'POST',
        data: {
            id_article: id_article
        },
        success: function (data) {
            refresh_personal_posts();
        },
        error: function (xhr, textStatus) {
            $('#modal-triggerer .modal-header h5').text("Erreur!");
            $('#modal-triggerer .modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function () {
                $('#modal-triggerer').modal('hide');
            }, 3000);
        }
    });
}

function get_update_form(id_article)
{
    $('.update-form-container').html("<img src='/src/public/img/ajax_loader_1.1.gif' class='update-form-loader'>");

    $.ajax({
        url: '/get_update_form',
        type: 'POST',
        data: {
            id_article: id_article
        },
        success: function (data) {
            $('.update-form-container').html(data);
            tinymceUpdateForm();
        },
        error: function (xhr, textStatus) {
            $('#modal-triggerer .modal-header h5').text("Erreur!");
            $('#modal-triggerer .modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function () {
                $('#modal-triggerer').modal('hide');
            }, 3000);
        }
    });
}

/*
    -- -- -- -- refresh fonctions -- -- -- --
    -- -- -- -- refresh fonctions -- -- -- --
    -- -- -- -- refresh fonctions -- -- -- --
 */

function refresh_posts() {
    $.ajax({
        url: '/refresh_posts',
        type: 'POST',
        success: function (data) {
            $('.all-posts.the-blog').fadeOut(300, function () {
                $('.all-posts.the-blog').html(data);
            }).fadeIn();
        },
        error: function (xhr, textStatus) {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function () {
                $('#modal-triggerer').modal('hide');
            }, 3000);
        }
    });
}

function refresh_personal_posts() {
    $.ajax({
        url: '/refresh_personal_posts',
        type: 'POST',
        success: function (data) {
            $('.user-articles-zone').fadeOut(300, function () {
                $('.user-articles-zone').html(data);
            }).fadeIn();
        },
        error: function (xhr, textStatus) {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function () {
                $('#modal-triggerer').modal('hide');
            }, 3000);
        }
    });
}