// step 1 js

//show step1 by default
$('#website-category-page').fadeIn('slow');

// var global
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
resetWebsiteCategory();

/**
 * Load website categories
 */
loadWebsiteCategories();


/**
 * @return {json data}
 */
function loadWebsiteCategories() {

	$.ajax({
		url: '/application/admin/modules/website_category/php/controller/website_category.controller.php',
		type: 'POST',
		data: {'action':'getAllWebsiteCategoriesDT'},
		success: function(response) {
			$("#dt_website_categories").empty().html(response);
		}
	}).done(function () {

		var table = $('#dt_website_categories').DataTable();
		table.destroy();

		$("#dt_website_categories").dataTable( {
	        scrollY: "400px",
			scrollCollapse: true,
			paging: false,
			searching: false,
			rowCallback: function ( row, data ) {
				$('input.input_dt_website_id', row).prop( 'checked', $('input.input_dt_use_url', row).val() == 1 );
	            // Set the checked state of the checkbox in the table
	            $('input.input_dt_use_url', row).prop( 'checked', $('input.input_dt_use_url', row).val() == 1 );
	            $('input.input_dt_use_pagination', row).prop( 'checked', $('input.input_dt_use_pagination', row).val() == 1 );
	        }
	    });

	    $('.delete_website_category_dt').off('click');
		$('.delete_website_category_dt').on('click', function() {
			deleteWebsiteCategory($(this));
		});

		$('.edit_website_category_dt').off('click');
		$('.edit_website_category_dt').on('click', function() {
			editWebsiteCategory($(this));
		});
	});

	$('#create_website_category').off('click');
	$('#create_website_category').on('click', function() {
		createWebsiteCategory();
	});

	$('#reset_website_category').off('click');
	$('#reset_website_category').on('click', function() {
		resetWebsiteCategory();
	});

	$.ajax({
		url: '/application/admin/modules/website_category/php/controller/website_category.controller.php',
		type: 'POST',
		data: {'action':'getAllCategories'},
		success: function(response) {
			$("#category-select").empty().html(response);
		}
	}).done(function () {
	});

	$.ajax({
		url: '/application/admin/modules/website_category/php/controller/website_category.controller.php',
		type: 'POST',
		data: {'action':'getAllWebsites'},
		success: function(response) {
			$("#website-select").empty().html(response);
		}
	}).done(function () {
	});
}

function editWebsiteCategory(button) {

	var id = $(button).parent().parent().attr('website_category_id');
	var category_id = $(button).parent().parent().find('.select_dt_category_id option:selected').val();
	var website_id = $(button).parent().parent().find('.select_dt_website_id option:selected').val();
	var category = $(button).parent().parent().find('.input_dt_website_category').val();
	var url = $(button).parent().parent().find('.input_dt_url').val();
	var use_url = ($(button).parent().parent().find('.input_dt_use_url').prop('checked') == true ? 1 : 0);
	var url_pagination = $(button).parent().parent().find('.input_dt_url_pagination').val();
	var use_pagination = ($(button).parent().parent().find('.input_dt_use_pagination').prop('checked') == true ? 1 : 0);

	$.ajax({
		url : '/application/admin/modules/website_category/php/controller/website_category.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'editWebsiteCategory', 
				'id': id,
				'category_id': category_id,
				'website_id': website_id,
				'category': category,
				'url': url,
				'use_url': use_url,
				'url_pagination': url_pagination,
				'use_pagination': use_pagination }
		}).done(function() {

		resetWebsiteCategory();
		loadWebsiteCategories();

	});
}

function deleteWebsiteCategory(button) {

	var id = $(button).parent().parent().attr('website_category_id');

	$.ajax({
		url : '/application/admin/modules/website_category/php/controller/website_category.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'deleteWebsiteCategory', 
				'id': id }
		}).done(function() {

		resetWebsiteCategory();
		loadWebsiteCategories();

	});
}

function createWebsiteCategory() {

	var category_id = $(".informations-website-category-new select[id=category-select] option:selected").val();
	var website_id = $(".informations-website-category-new select[id=website-select] option:selected").val();
	var category = $(".informations-website-category-new input[id=website-category]").val();
	var url = $(".informations-website-category-new input[id=url]").val();
	var use_url = ($(".informations-website-category-new input[id=use-url]").prop('checked') == true ? 1 : 0);
	var url_pagination = $(".informations-website-category-new input[id=url-pagination]").val();
	var use_pagination = ($(".informations-website-category-new input[id=use-pagination]").prop('checked') == true ? 1 : 0);

	$.ajax({
		url : '/application/admin/modules/website_category/php/controller/website_category.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'createWebsiteCategory', 
				'category_id': category_id,
				'website_id': website_id,
				'category': category,
				'url': url,
				'use_url': use_url,
				'url_pagination': url_pagination,
				'use_pagination': use_pagination }
		}).done(function() {

		resetWebsiteCategory();
		loadWebsiteCategories();

	});
}


///// Fonction système

function resetWebsiteCategory() {

	$(".informations-website-category-new select[id=category-select]").empty();
	$(".informations-website-category-new select[id=website-select]").empty();
	$(".informations-website-category-new input[id=website-category]").val('');
	$(".informations-website-category-new input[id=url]").val('');
	$(".informations-website-category-new input[id=use-url]").attr('checked', false);
	$(".informations-website-category-new input[id=url-pagination]").val('');
	$(".informations-website-category-new input[id=use-pagination]").attr('checked', false);
}
