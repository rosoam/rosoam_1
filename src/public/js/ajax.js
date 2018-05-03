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
            $('.modal-header h5').text("Succès!");
            $('.modal-body').text(data);
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
            $('.modal-header h5').text("Succès!");
            $('.modal-body').text(data);
            $('#modal-triggerer').modal('show');
            setTimeout(function(){ location.reload(); },3000);
        },
        error: function(xhr, textStatus)
        {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function(){ $('#modal-triggerer').modal('hide'); },3000);
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
            $('.modal-header h5').text("Succès!");
            $('.modal-body').text(data);
            $('#modal-triggerer').modal('show');
            setTimeout(function(){ $('#modal-triggerer').modal('hide'); },3000);
        },
        error: function(xhr, textStatus)
        {
            $('.modal-header h5').text("Erreur!");
            $('.modal-body').text(xhr.responseText);
            $('#modal-triggerer').modal('show');
            setTimeout(function(){ $('#modal-triggerer').modal('hide'); },3000);        }
    })
}

$('#test').click(function(){
    $('#modal-triggerer').modal('show');
});