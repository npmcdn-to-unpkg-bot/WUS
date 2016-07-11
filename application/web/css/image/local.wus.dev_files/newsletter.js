$(document).ready(function() {
    $('.newsletter_valider').off('click');
    $('.newsletter_valider').on('click', function(e) {

        var email = $('#newsletter_email').val();

        $.ajax({
            url: "application/web/ajax/controller.newsletter.php",
            type: "POST",        
            data: { 
                'action' : 'createNewsletter',
                'email' : email
            },
            success: function(data) {

                if(data == 0) {
                    $('#newsletter_email').val('');
                    $('.newsletter .data .valid').fadeIn(300).fadeOut(3000);
                }
            }
        }).done(function(data) {
        }).fail(function( jqXHR, textStatus ) {
        });
    });
});