$("#connexion").off('click');
$("#connexion").on('click', function() {

    //Getting the variable's value from a link 
    var loginBox = $(this).attr('href');

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
});

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
$(".login-close").on('click', function() {
    $('#mask, .login-popup').fadeOut(300 , function() {
        $('.sign-valid').fadeOut(0);
        $('.sign-error').fadeOut(0);
        $('#login-site').fadeOut(0);
        $('#sign').fadeOut(0);
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