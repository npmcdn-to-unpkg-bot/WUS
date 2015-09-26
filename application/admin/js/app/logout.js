$("#admin_logout").off('click');
$("#admin_logout").on('click', function() {

	logout();
    
});

function logout() {
	$.ajax({
        url : '/application/admin/ajax/logout.php', // La ressource ciblée
        type : 'POST', // Le type de la requête HTTP
        data : { 'action': 'logout' },
        success : function(data){
            document.location.href = "/admin";                             
        }
    });
}