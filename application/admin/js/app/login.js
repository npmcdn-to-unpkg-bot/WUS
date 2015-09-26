$("#submit_admin_login").off('click');
$("#submit_admin_login").on('click', function() {
    login();
});

function login() {
    var login = $("#admin_login").val();
    var pass = $("#admin_pass").val();

    $.ajax({
        url : '/application/admin/ajax/login.php', // La ressource ciblée
        type : 'POST', // Le type de la requête HTTP
        data : { 'action': 'login',
        'login' : login,
        'pass' : pass },
        success : function(data){
            if(data == 1) {
                alert("Vous êtes maintenant connecté !");
                $(location).attr('href',"http://local.wus.dev/admin");
            }
            else {
                alert("Erreur de connexion !");
                $(location).attr('href',"http://local.wus.dev/admin");
            }                             
        }
    });
}