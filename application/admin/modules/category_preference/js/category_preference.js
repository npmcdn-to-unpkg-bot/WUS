// step 1 js

//show step1 by default
$('#category-preference-page').fadeIn('slow');

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
resetCategoryPreference();

/**
 * Load category preferences
 */
loadCategoryPreferences();


/**
 * @return {json data}
 */
function loadCategoryPreferences() {

	$.ajax({
		url: '/application/admin/modules/category_preference/php/controller/category_preference.controller.php',
		type: 'POST',
		data: {'action':'getAllCategoryPreferencesDT'},
		success: function(response) {
			$("#dt_category_preferences").empty().html(response);
		}
	}).done(function () {

		var table = $('#dt_category_preferences').DataTable();
		table.destroy();

		$("#dt_category_preferences").dataTable( {
	        scrollY: "400px",
			scrollCollapse: true,
			paging: false,
			searching: false
	    });

	    $('.delete_category_preference_dt').off('click');
		$('.delete_category_preference_dt').on('click', function() {
			deleteCategoryPreference($(this));
		});

		$('.edit_category_preference_dt').off('click');
		$('.edit_category_preference_dt').on('click', function() {
			editCategoryPreference($(this));
		});
	});

	$('#create_category_preference').off('click');
	$('#create_category_preference').on('click', function() {
		createCategoryPreference();
	});

	$('#reset_category_preference').off('click');
	$('#reset_category_preference').on('click', function() {
		resetCategoryPreference();
	});

	$.ajax({
		url: '/application/admin/modules/category_preference/php/controller/category_preference.controller.php',
		type: 'POST',
		data: {'action':'getAllUsers'},
		success: function(response) {
			$("#user-select").empty().html(response);
		}
	}).done(function () {
	});

	$.ajax({
		url: '/application/admin/modules/category_preference/php/controller/category_preference.controller.php',
		type: 'POST',
		data: {'action':'getAllCategories'},
		success: function(response) {
			$("#category-select").empty().html(response);
		}
	}).done(function () {
	});
}

function editCategoryPreference(button) {

	var id = $(button).parent().parent().attr('category_preference_id');
	var user_id = $(button).parent().parent().find('.select_dt_user_id option:selected').val();
	var category_id = $(button).parent().parent().find('.select_dt_category_id option:selected').val();

	$.ajax({
		url : '/application/admin/modules/category_preference/php/controller/category_preference.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'editCategoryPreference', 
				'id': id,
				'user_id': user_id,
				'category_id': category_id }
		}).done(function() {

		resetCategoryPreference();
		loadCategoryPreferences();

	});
}

function deleteCategoryPreference(button) {

	var id = $(button).parent().parent().attr('category_preference_id');

	$.ajax({
		url : '/application/admin/modules/category_preference/php/controller/category_preference.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'deleteCategoryPreference', 
				'id': id }
		}).done(function() {

		resetCategoryPreference();
		loadCategoryPreferences();

	});
}

function createCategoryPreference() {

	var user_id = $(".informations-category-preference-new select[id=user-select] option:selected").val();
	var category_id = $(".informations-category-preference-new select[id=category-select] option:selected").val();

	$.ajax({
		url : '/application/admin/modules/category_preference/php/controller/category_preference.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'createCategoryPreference', 
				'user_id': user_id,
				'category_id': category_id }
		}).done(function() {

		resetCategoryPreference();
		loadCategoryPreferences();

	});

}


///// Fonction système

function resetCategoryPreference() {

	$(".informations-category-preference-new select[id=user-select] option:first").prop('selected', true);
	$(".informations-category-preference-new select[id=category-select] option:first").prop('selected', true);
}
