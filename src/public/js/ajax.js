function subscribe_user(username, email, password, confirm_password)
{
    $.ajax
    ({
        url:'http://localhost/subscribe_user/',
        dataType: 'html',
        type: 'POST',
        data:{username:username, email:email, password:password, confirm_password:confirm_password},
        success: function(data)
        {
            $('.success-triggerer p').text(data);
            $('.success-triggerer').addClass('success-active');
            setTimeout(function(){ $('.success-triggerer').removeClass('success-active'); },4000);
        },
        error: function(xhr, textStatus)
        {
            $('.error-triggerer p').text(xhr.responseText);
            $('.error-triggerer').addClass('error-active');
            setTimeout(function(){ $('.error-triggerer').removeClass('error-active'); },4000);
        }
    })
}

function login_user(username, password)
{
    $.ajax
    ({
        url:'http://localhost/login_user/',
        dataType: 'html',
        type: 'POST',
        data:{username:username, password:password},
        success: function(data)
        {
            $('.success-triggerer p').text(data);
            $('.success-triggerer').addClass('success-active');
            setTimeout(function(){
                $('.success-triggerer').removeClass('success-active');
                location.reload();
            },4000);
        },
        error: function(xhr, textStatus)
        {
            $('.error-triggerer p').text(xhr.responseText);
            $('.error-triggerer').addClass('error-active');
            setTimeout(function(){ $('.error-triggerer').removeClass('error-active'); },4000);
        }
    })
}

function logout()
{
    $.ajax
    ({
        url:'http://localhost/logout/',
        dataType: 'html',
        type: 'POST',
        success: function(data)
        {
            $('.success-triggerer p').text(data);
            $('.success-triggerer').addClass('success-active');
            setTimeout(function(){
                $('.success-triggerer').removeClass('success-active');
                location.reload();
            },4000);
        },
        error: function(xhr, textStatus)
        {
            $('.error-triggerer p').text(xhr.responseText);
            $('.error-triggerer').addClass('error-active');
            setTimeout(function(){ $('.error-triggerer').removeClass('error-active'); },4000);
        }
    })
}