// step 1 js

//show step1 by default
$('#type-item-page').fadeIn('slow');

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
resetTypeItem();

/**
 * Load categories
 */
loadTypeItems();


/**
 * @return {json data}
 */
function loadTypeItems() {

	$.ajax({
		url: '/application/admin/modules/type_item/php/controller/type_item.controller.php',
		type: 'POST',
		data: {'action':'getAllTypeItemsDT'},
		success: function(response) {
			$("#dt_type_items").empty().html(response);
		}
	}).done(function () {

		var table = $('#dt_type_items').DataTable();
		table.destroy();

		$("#dt_type_items").dataTable( {
	        scrollY: "400px",
			scrollCollapse: true,
			paging: false,
			searching: false
	    });

	    $('.delete_type_item_dt').off('click');
		$('.delete_type_item_dt').on('click', function() {
			deleteTypeItem($(this));
		});

		$('.edit_type_item_dt').off('click');
		$('.edit_type_item_dt').on('click', function() {
			editTypeItem($(this));
		});
	});

	$('#create_type_item').off('click');
	$('#create_type_item').on('click', function() {
		createTypeItem();
	});

	$('#reset_type_item').off('click');
	$('#reset_type_item').on('click', function() {
		resetTypeItem();
	});
}

function editTypeItem(button) {

	var id = $(button).parent().parent().attr('type_item_id');
	var type = $(button).parent().parent().find('.input_dt_type').val();

	$.ajax({
		url : '/application/admin/modules/type_item/php/controller/type_item.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'editTypeItem', 
				'id': id,
				'type': type }
		}).done(function() {

		resetTypeItem();
		loadTypeItems();

	});
}

function deleteTypeItem(button) {

	var id = $(button).parent().parent().attr('type_item_id');

	$.ajax({
		url : '/application/admin/modules/type_item/php/controller/type_item.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'deleteTypeItem', 
				'id': id }
		}).done(function() {

		resetTypeItem();
		loadTypeItems();

	});
}

function createTypeItem() {

	var type = $(".informations-type-item-new input[id=type]").val();

	$.ajax({
		url : '/application/admin/modules/type_item/php/controller/type_item.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'createTypeItem', 
				'type': type }
		}).done(function() {

		resetTypeItem();
		loadTypeItems();

	});

}


///// Fonction système

function resetTypeItem() {

	$(".informations-type-item-new input[id=type]").val('');
}
