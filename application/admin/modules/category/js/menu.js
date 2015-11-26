
$("#manage-websites").off('click');
$("#manage-websites").on(function() {

	$("#website-page").fadeIn("slow");

});

// back to admin click event
$("#back-to-admin").off('click');
$("#back-to-admin").on(function() {
	document.location.href = "/admin";
});

// manage contacts click event
$("#disconnect-admin").off('click');
$("#disconnect-admin").on(function() {

	$.ajax({
        url : '/application/admin/ajax/logout.php', // La ressource ciblée
        type : 'POST', // Le type de la requête HTTP
        data : { 'action': 'logout' },
        success : function(data){
            document.location.href = "/admin";                            
        }
    });

});