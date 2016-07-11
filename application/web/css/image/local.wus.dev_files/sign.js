$(document).ready(function() {
    $('.sign').off('click');
    $('.sign').on('click', function(e) {

        var first_name = $('#sign-first-name').val();
        var last_name = $('#sign-last-name').val();
        var birthday = $('#sign-birthday').val();
        var sex = $(".sign-sex:checked").val();
        var email = $('#sign-email').val();
        var email_conf = $('#sign-email-conf').val();
        var password = $('#sign-password').val();
        var g_recaptcha_response = $('#g-recaptcha-response').val();

        $.ajax({
            url: "application/web/ajax/controller.sign.php",
            type: "POST",        
            data: { 
                'action' : 'sign',
                'first-name' : first_name,
                'last-name' : last_name,
                'birthday' : birthday,
                'sex' : sex,
                'email' : email,
                'email-conf' : email_conf,
                'password' : password,
                'g-recaptcha-response' : g_recaptcha_response
            },
            success: function(data) {

                if(data != 0) {
                    $('.form-sign').fadeOut(0);
                    $('.sign-error').fadeIn(300);
                }
                else {
                    $('.form-sign').fadeOut(0);
                    $('.sign-valid').fadeIn(300);
                }
            }
        }).done(function(data) {
        }).fail(function( jqXHR, textStatus ) {
        });
    });
});