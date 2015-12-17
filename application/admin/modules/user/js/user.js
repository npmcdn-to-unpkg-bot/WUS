// step 1 js

//show step1 by default
$('#user-page').fadeIn('slow');

var delay = ( function() {
    var timer = 0;
    return function(callback, ms) {
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

/*
	Reset all
 */
resetUser();

/**
 * Load users
 */
loadUsers();


/**
 * @return {json data}
 */
function loadUsers() {

	$.ajax({
		url: '/application/admin/modules/user/php/controller/user.controller.php',
		type: 'POST',
		data: {'action':'getAllUsersDT'},
		success: function(response) {
			$("#dt_users").empty().html(response);
		}
	}).done(function () {

		var table = $('#dt_users').DataTable();
		table.destroy();

		$("#dt_users").dataTable( {
	        scrollY: "400px",
			scrollCollapse: true,
			paging: false,
			searching: false,
			rowCallback: function ( row, data ) {
	            // Set the checked state of the checkbox in the table
	            $('input.input_dt_valid', row).prop( 'checked', $('input.input_dt_valid', row).val() == 1 );
	        }
	    });

	    $('.delete_user_dt').off('click');
		$('.delete_user_dt').on('click', function() {
			deleteUser($(this));
		});

		$('.edit_user_dt').off('click');
		$('.edit_user_dt').on('click', function() {
			editUser($(this));
		});
	});

	$('#create_user').off('click');
	$('#create_user').on('click', function() {
		createUser();
	});

	$('#reset_user').off('click');
	$('#reset_user').on('click', function() {
		resetUser();
	});
}

function editUser(button) {

	var id = $(button).parent().parent().attr('user_id');
	var name = $(button).parent().parent().find('.input_dt_name').val();
	var login = $(button).parent().parent().find('.input_dt_login').val();
	var pass = $(button).parent().parent().find('.input_dt_pass').val();
	var valid = ($(button).parent().parent().find('.input_dt_valid').prop('checked') == true ? 1 : 0);

	$.ajax({
		url : '/application/admin/modules/user/php/controller/user.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'editUser', 
				'id': id,
				'name': name,
				'login': login,
				'pass': pass,
				'valid': valid }
		}).done(function() {

		resetUser();
		loadUsers();

	});
}

function deleteUser(button) {

	var id = $(button).parent().parent().attr('user_id');

	$.ajax({
		url : '/application/admin/modules/user/php/controller/user.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'deleteUser', 
				'id': id }
		}).done(function() {

		resetUser();
		loadUsers();

	});
}

function createUser() {

	var name = $(".informations-user-new input[id=name]").val();
	var login = $(".informations-user-new input[id=login]").val();
	var pass = $(".informations-user-new input[id=pass]").val();
	var valid = ($(".informations-user-new input[id=valid]").prop('checked') == true ? 1 : 0);

	console.log(valid);

	$.ajax({
		url : '/application/admin/modules/user/php/controller/user.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'createUser', 
				'name': name,
				'login': login,
				'pass': pass,
				'valid': valid }
		}).done(function() {

		resetUser();
		loadUsers();

	});

}


///// Fonction système

function resetUser() {

	$(".informations-user-new input[id=name]").val('');
	$(".informations-user-new input[id=login]").val('');
	$(".informations-user-new input[id=pass]").val('');
	$(".informations-user-new input[id=valid]").attr('checked', false);
}
