// step 1 js

//show step1 by default
$('#category-page').fadeIn('slow');

// var global
var logo = null;

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
resetCategory();

/**
 * Load categories
 */
loadCategories();


/**
 * @return {json data}
 */
function loadCategories() {

	$.ajax({
		url: '/application/admin/modules/category/php/controller/category.controller.php',
		type: 'POST',
		data: {'action':'getAllCategoriesDT'},
		success: function(response) {
			$("#dt_categories").empty().html(response);
		}
	}).done(function () {

		var table = $('#dt_categories').DataTable();
		table.destroy();

		$("#dt_categories").dataTable( {
	        scrollY: "400px",
			scrollCollapse: true,
			paging: false,
			searching: false
	    });

	    $('.delete_category_dt').off('click');
		$('.delete_category_dt').on('click', function() {
			deleteCategory($(this));
		});

		$('.edit_category_dt').off('click');
		$('.edit_category_dt').on('click', function() {
			editCategory($(this));
		});
	});

	$('#create_category').off('click');
	$('#create_category').on('click', function() {
		createCategory();
	});

	$('#reset_category').off('click');
	$('#reset_category').on('click', function() {
		resetCategory();
	});
}

function editCategory(button) {

	var id = $(button).parent().parent().attr('categoryId');
	var category = $(button).parent().parent().find('.input_dt_category').val();

	$.ajax({
		url : '/application/admin/modules/category/php/controller/category.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'editCategory', 
				'id': id,
				'category': category }
		}).done(function() {

		resetCategory();
		loadCategories();

	});
}

function deleteCategory(button) {

	var id = $(button).parent().parent().attr('categoryId');

	$.ajax({
		url : '/application/admin/modules/category/php/controller/category.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'deleteCategory', 
				'id': id }
		}).done(function() {

		resetCategory();
		loadCategories();

	});
}

function createCategory() {

	var category = $(".informations-category-new input[id=category]").val();

	$.ajax({
		url : '/application/admin/modules/category/php/controller/category.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'createCategory', 
				'category': category }
		}).done(function() {

		resetCategory();
		loadCategories();

	});

}


///// Fonction système

function resetCategory() {

	$(".informations-category-new input[id=category]").val('');
}
