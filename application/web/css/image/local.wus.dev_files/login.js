$(document).ready(function() {
    CheckSessionAuth();
});

function CheckSessionAuth()
{
    $.ajax({
        url: "application/web/ajax/controller.login.php",
        type: "POST",        
        data: { 
            'action' : 'checkSessionAuth'
        },
        success: function(data) {

            if(data == false) {
                $('#is_connect').val('0');
                $(".login-close").hide();
                OpenPopupLogin($("#login"));
            } else {
                $('#is_connect').val('1');
                $(".login-close").show();
            }
        }
    }).done(function(data) {
    }).fail(function( jqXHR, textStatus ) {
    });
}

$('body').off('click');
$('body').on('click', function(e) {

    var is_connect = $('#is_connect').val();

    if(is_connect === '0') {
        //e.preventDefault();
        $(".login-close").hide();

        if (!$('#mask').length) {
            OpenPopupLogin($("#login"));
        }
    } else {
        $(".login-close").show();
    }
});

/*$("#connexion").off('click');
$("#connexion").on('click', function() {
    OpenPopupLogin($(this));
});*/

function OpenPopupLogin(object)
{
    //Getting the variable's value from a link 
    var loginBox = $(object);

    //Fade in the Popup
    $(loginBox).fadeIn(300);
    
    //Set the center alignment padding + border see css style
    var popMargTop = ($(loginBox).height() + 24) / 2; 
    var popMargLeft = ($(loginBox).width() + 24) / 2; 
    
    $(loginBox).css({ 
        'margin-top' : -popMargTop,
        'margin-left' : -popMargLeft
    });
    
    // Add the mask to body
    $('body').append('<div id="mask"></div>');
    $('#mask').fadeIn(300);
    
    return false;
}

$('.other-login').off('click');
$('.other-login').on('click', function() {
    var other = $(this).attr('href');

    $(other).fadeIn(300);

    var popMargTop = ($("#login").height() + 24) / 2; 
    var popMargLeft = ($("#login").width() + 24) / 2; 
    
    $("#login").css({ 
        'margin-top' : -popMargTop,
        'margin-left' : -popMargLeft
    });
});

$('.lost-password').off('click');
$('.lost-password').on('click', function() {

    $('#login-social').fadeOut(0);
    $('.sign-valid').fadeOut(0);
    $('.sign-error').fadeOut(0);
    $('#login-site').fadeOut(0);
    $('#sign').fadeOut(0);

    var other = $(this).attr('href');

    $(other).fadeIn(300);

    var popMargTop = ($("#login").height() + 24) / 2; 
    var popMargLeft = ($("#login").width() + 24) / 2; 
    
    $("#login").css({ 
        'margin-top' : -popMargTop,
        'margin-left' : -popMargLeft
    });
});

$(".lost-password-validate").off('click');
$(".lost-password-validate").on('click', function() {

    var email = $('#lost-password-username').val();

    $.ajax({
        url: "application/web/ajax/controller.login.php",
        type: "POST",        
        data: { 
            'action' : 'lostPassword',
            'email' : email
        },
        success: function(data) {

            if(data != 0) {
                $('.form-lost-password').fadeOut(0);
                $('.lost-password-error').fadeIn(300);
            }
            else {
                $('.form-lost-password').fadeOut(0);
                $('.lost-password-valid').fadeIn(300);
            }
        }
    }).done(function(data) {
    }).fail(function( jqXHR, textStatus ) {
    });
});

$("#deconnexion").off('click');
$("#deconnexion").on('click', function() {

    $.ajax({
        url: "application/web/ajax/controller.login.php",
        type: 'POST',
        data: {'action':'logout'}
    }).done(function(response) {
        // Puis appeler la fonction de rechargement ajax de
        // la timeline qui ira chercher les cookies en cours.
        if(response == 0) {
            //location.reload();
            $(location).attr('href',"/");
        } else {
            alert('Erreur de deconnexion !');
        }
    });

    return false;
});

// When clicking on the button close or the mask layer the popup closed
$(".login-close").off('click');
$(".login-close").on('click', function(e) {

    e.preventDefault();

    var is_connect = $('#is_connect').val();

    if(is_connect === '0') {
        return false;
    }

    $('#mask, .login-popup').fadeOut(300 , function() {
        $('.lost-password-valid').fadeOut(0);
        $('.lost-password-error').fadeOut(0);
        $('#lost-password').fadeOut(0);
        $('.sign-valid').fadeOut(0);
        $('.sign-error').fadeOut(0);
        $('#login-site').fadeOut(0);
        $('#sign').fadeOut(0);
        $('#login-social').fadeIn(300);
        $('#mask').remove();  
    }); 
    return false;
});

$(".login-site").off('click');
$(".login-site").on('click', function() {

    var username = $('#username').val();
    var password = $('#password').val();

    $.ajax({
        url: "application/web/ajax/controller.login.php",
        type: 'POST',
        data: {'action':'login', 'username':username, 'password':password}
    }).done(function(response) {
        // Puis appeler la fonction de rechargement ajax de
        // la timeline qui ira chercher les cookies en cours.
        if(response == 0) {
            location.reload();
        } else {
            alert('Erreur de connexion !');
        }
    });

    return false;
});

/*$(".provider").off('click');
$(".provider").on('click', function() {

    var provider = $(this).attr('provider');

    $.ajax({
        url: "application/web/ajax/controller.login.php",
        type: 'POST',
        data: {'action':'loginByProvider', 'provider':provider}
    }).done(function(response) {
        // Puis appeler la fonction de rechargement ajax de
        // la timeline qui ira chercher les cookies en cours.
        if(response == 0) {
            location.reload();
        } else {
            alert('Erreur de connexion !');
        }
    });

    return false;
});*/