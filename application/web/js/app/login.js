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

$("#deconnexion").off('click');
$("#deconnexion").on('click', function() {

    $.ajax({
        url: "application/web/ajax/controller.login.php",
        type: 'POST',
        data: {'action':'logout'}
    }).done(function(response) {
        // Puis appeler la fonction de rechargement ajax de
        // la timeline qui ira chercher les cookies en cours.
        if(response == 1) {
            location.reload();
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
        $('#mask').remove();  
    }); 
    return false;
});

$(".sign-in").off('click');
$(".sign-in").on('click', function() {

    var username = $('#username').val();
    var password = $('#password').val();

    $.ajax({
        url: "application/web/ajax/controller.login.php",
        type: 'POST',
        data: {'action':'login', 'username':username, 'password':password}
    }).done(function(response) {
        // Puis appeler la fonction de rechargement ajax de
        // la timeline qui ira chercher les cookies en cours.
        if(response == 1) {
            location.reload();
        } else {
            alert('Erreur de connexion !');
        }
    });

    return false;
});