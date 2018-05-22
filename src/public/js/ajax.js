function subscribe_user(username, email, password, confirm_password)
{
    $.ajax
    ({
        url:'/subscribe_user/',
        dataType: 'html',
        type: 'POST',
        data:{username:username, email:email, password:password, confirm_password:confirm_password},
        success: function(data)
        {
            $('.modal-header h5').text("Succès!");
            $('.modal-body').text("Merci, vérifiez vos mails afin de valider votre compte!");
            $('#modal-triggerer').modal('show');
            setTimeout(function(){ $('#modal-triggerer').modal('hide'); },3000);
        },
        error: function(xhr, textStatus)
        {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function(){ $('#modal-triggerer').modal('hide'); },3000);
        }
    });
}

function login_user(username, password)
{
    $.ajax
    ({
        url:'/login_user/',
        dataType: 'html',
        type: 'POST',
        data:{username:username, password:password},
        success: function(data)
        {
            location.reload();
        },
        error: function(xhr, textStatus)
        {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function(){ $('#modal-triggerer').modal('hide'); },3000);
        }
    });
}

function logout()
{
    $.ajax
    ({
        url:'/logout/',
        dataType: 'html',
        type: 'POST',
        success: function(data)
        {
            location.reload();
        },
        error: function(xhr, textStatus)
        {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function(){ $('#modal-triggerer').modal('hide'); },3000);        }
    });
}

$("#file-send").submit(function(e){
    //e.preventDefault();
    var formData = new FormData($(this)[0]);

    $.ajax({
        url: '/send-file',
        type: 'POST',
        data: formData,
        success: function (data) {
            $('.modal-header h5').text("Succès!");
            $('.modal-body').text(data);
            $('#modal-triggerer').modal('show');
            setTimeout(function(){ $('#modal-triggerer').modal('hide'); },3000);
        },
        cache: false,
        contentType: false,
        processData: false,
        error: function(xhr, textStatus)
        {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function(){ $('#modal-triggerer').modal('hide'); },3000);
        }
    });

    return false;
});

$('.more-posts').click(function(e){
   e.preventDefault();
    var count = 0;
   $('.homepage-blog .blog-post.box').each(function(){
       count++;
   });
   var newLimit = count + 4;
   more_posts(count,newLimit);

});


// PARTIALS LOAD

function more_posts(count, limit)
{
    $.ajax
    ({
        url:'/more_posts',
        type: 'POST',
        dataType: 'html',
        data:{count:count,limit:limit},
        success: function(data)
        {
            $('.homepage-blog').fadeOut(300,function(){
               $('.homepage-blog').html(data);
            }).fadeIn();
        },
        error: function(xhr, textStatus)
        {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function(){ $('#modal-triggerer').modal('hide'); },3000);        }
    });
}

// /auteur_posts

$('.get-auteur-posts').click(function(e){
   e.preventDefault();
   var auteur = $('.auteurs-area form #auteur').val();

   auteur_posts(auteur);
});

function auteur_posts(auteur)
{
    $.ajax
    ({
        url:'/auteur_posts',
        type: 'POST',
        dataType: 'html',
        data:{auteur:auteur},
        success: function(data)
        {
            $('.all-posts.the-blog').fadeOut(300,function(){
                $('.all-posts.the-blog').html(data);
            }).fadeIn();
        },
        error: function(xhr, textStatus)
        {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function(){ $('#modal-triggerer').modal('hide'); },3000);        }
    });
}

$('.tag_search').click(function(e){
   e.preventDefault();
   var tags = [];

   $('.tag-item.active').each(function(){
       tags.push($(this).text());
   });

   get_tags_articles(tags);
});

$('.tag-item').click(function(e){
   e.preventDefault();
});

function get_tags_articles(tags)
{
    $.ajax
    ({
        url:'/tags_posts',
        type: 'POST',
        dataType: 'html',
        data:{tags:tags},
        success: function(data)
        {
            $('.all-posts.the-blog').fadeOut(300,function(){
                $('.all-posts.the-blog').html(data);
            }).fadeIn();
        },
        error: function(xhr, textStatus)
        {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            //setTimeout(function(){ $('#modal-triggerer').modal('hide'); },3000);
        }
    });
}