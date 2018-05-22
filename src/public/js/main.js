$(document).ready(function(){
    var called = false;
    $('#inscription-submit').click(function(e){
        e.preventDefault();
        
        var $form_username = $('#inscription-form #username').val();
        var $form_email = $('#inscription-form #email').val();
        var $form_password = $('#inscription-form #password').val();
        var $form_confirmPassword = $('#inscription-form #confirmPassword').val();
h
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
    });

    $('#update-profil-picture').on('change', function(){
        readURL(this);
    });

    resizeHeader();
    resizeBlogBoxes();

    $(window).resize(function(){
        resizeBlogBoxes();
        resizeHeader();
    });

    $('.tag-item').click(function(){
        switchActiveClass($(this));
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

window.sr = ScrollReveal();
sr.reveal('.logo-ressources', { duration: 1000,delay:200, origin:'bottom' });

function resizeBlogBoxes()
{
    var firstBlogPostWidth = $('.blog-post:first-of-type').width();
    var heightSecondAndThirdBlogPost = (firstBlogPostWidth / 2) - 5;
    var otherBoxesWidth = $('.blog-post:nth-of-type(4)').width();

    $('.blog-post:first-of-type').height(firstBlogPostWidth);
    $('.blog-post:nth-of-type(2), .blog-post:nth-of-type(3)').css('height', heightSecondAndThirdBlogPost);
    $('.blog-post:nth-of-type(1n+4)').height(otherBoxesWidth);
}

function resizeHeader()
{
    var menuHeight = $('#menu').height();
    $('#header').css('margin-top', menuHeight);
}

function switchActiveClass(element)
{
    var element = $(element);
    if(element.hasClass('active'))
    {
        element.removeClass('active');
    }
    else
    {
        element.addClass('active');
    }
}