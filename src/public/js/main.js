$(document).ready(function(){
    var called = false;
    $('#inscription-submit').click(function(e){
        e.preventDefault();
        
        var $form_username = $('#inscription-form #username').val();
        var $form_email = $('#inscription-form #email').val();
        var $form_password = $('#inscription-form #password').val();
        var $form_confirmPassword = $('#inscription-form #confirmPassword').val();

        subscribe_user($form_username, $form_email, $form_password, $form_confirmPassword);
    });

    $('#connect-submit').click(function(e){
        e.preventDefault();
        
        var $form_username = $('#connection-form #username').val();
        var $form_password = $('#connection-form #password').val();

        login_user($form_username, $form_password);
    });

    $('.logout').click(function(e){
        e.preventDefault();
        logout();
    })

    /*
    $('#add-post-submit').on('click', function(e){
        e.preventDefault();
        var $title_post = $('#add-post-form #title_post').val();
        var $author_post = $('#add-post-form #author_post').val();
        var $extrait_post = $('#add-post-form #extrait_post').val();
        var $content_post = $('#add-post-form #content_post').val();

        add_post($title_post, $author_post, $extrait_post, $content_post);
        return false;
    });

    $('.post-back-link').click(function(e){
        e.preventDefault();
        history.go(-1);
    });

    $('.appear-add-post, .cliquable-area').click(function(){
        $('.add-post-section').fadeToggle(200);
    });*/
});

/*$('.personal-blog').on('click', '.delete-post', function (e){
    e.preventDefault();
    var $id_post = this.id;

    if(confirm('Etes-vous sûr de vouloir supprimer cet article?'))
    {
        delete_post($id_post);
        return false;
    }
    else
    {
        // nothing
        return false;
    }
});

$(".blog-area, .personal-blog-area").hide(0).fadeIn(700);*/
