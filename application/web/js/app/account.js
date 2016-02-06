$(document).ready(function() {
    $('.account').off('click');
    $('.account').on('click', function(e) {

        var first_name = $('#first-name').val();
        var last_name = $('#last-name').val();
        var birthday = $('#birthday').val();
        var sex = $(".sex:checked").val();
        var email = $('#email').val();
        var password = $('#password').val();
        var newsletter = $("#newsletter:checked").val();

        $.ajax({
            url: "application/web/ajax/controller.account.php",
            type: "POST",        
            data: { 
                'action' : 'updateAccount',
                'first-name' : first_name,
                'last-name' : last_name,
                'birthday' : birthday,
                'sex' : sex,
                'email' : email,
                'password' : password,
                'newsletter' : newsletter
            },
            success: function(data) {

                if(data == 0) {
                    $('.compte .valid').fadeIn(300).fadeOut(3000);
                }
                else {
                    $('.compte .error').fadeIn(300).fadeOut(3000);
                }
            }
        }).done(function(data) {
        }).fail(function( jqXHR, textStatus ) {
        });
    });
});