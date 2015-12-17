// step 1 js

//show step1 by default
$('#item-page').fadeIn('slow');

// var global
var image = null;

var delay = ( function() {
    var timer = 0;
    return function(callback, ms) {
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

var settings = null;
var uploadObj = null;

/*
	Reset all
 */
resetItem();

/**
 * Load categories
 */
loadItems();


/**
 * @return {json data}
 */
function loadItems() {

	$.ajax({
		url: '/application/admin/modules/item/php/controller/item.controller.php',
		type: 'POST',
		data: {'action':'getAllItemsDT'},
		success: function(response) {
			$("#dt_items").empty().html(response);
		}
	}).done(function () {

		var table = $('#dt_items').DataTable();
		table.destroy();

		$("#dt_items").dataTable( {
	        scrollY: "400px",
			scrollCollapse: true,
			paging: false,
			searching: false
	    });

	    $('.delete_item_dt').off('click');
		$('.delete_item_dt').on('click', function() {
			deleteItem($(this));
		});

		$('.edit_item_dt').off('click');
		$('.edit_item_dt').on('click', function() {
			editItem($(this));
		});
	});

	$('#create_item').off('click');
	$('#create_item').on('click', function() {
		createItem();
	});

	$('#reset_item').off('click');
	$('#reset_item').on('click', function() {
		resetItem();
	});

	$.ajax({
		url: '/application/admin/modules/item/php/controller/item.controller.php',
		type: 'POST',
		data: {'action':'getAllTypeItems'},
		success: function(response) {
			$("#type-item-select").empty().html(response);
		}
	}).done(function () {
	});

	$.ajax({
		url: '/application/admin/modules/item/php/controller/item.controller.php',
		type: 'POST',
		data: {'action':'getAllWebsiteCategories'},
		success: function(response) {
			$("#website-category-select").empty().html(response);
		}
	}).done(function () {
	});
}

function editItem(button) {

	var id = $(button).parent().parent().attr('item_id');
	var type_item_id = $(button).parent().parent().find('.select_dt_type_item_id option:selected').val();
	var website_category_id = $(button).parent().parent().find('.select_dt_website_category_id option:selected').val();
	var guid = $(button).parent().parent().find('.input_dt_guid').val();
	var url = $(button).parent().parent().find('.input_dt_url').val();
	var title = $(button).parent().parent().find('.input_dt_title').val();
	var width_image = $(button).parent().parent().find('.input_dt_width_image').val();
	var height_image = $(button).parent().parent().find('.input_dt_height_image').val();
	var image = $(button).parent().parent().find('.input_dt_image').val();
	var alt_image = $(button).parent().parent().find('.input_dt_alt_image').val();
	var description = $(button).parent().parent().find('.input_dt_description').val();
	var date_publication = $(button).parent().parent().find('.input_dt_date_publication').val();
	var author = $(button).parent().parent().find('.input_dt_author').val();

	$.ajax({
		url : '/application/admin/modules/item/php/controller/item.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'editItem', 
				'id': id,
				'type_item_id': type_item_id,
				'website_category_id': website_category_id,
				'guid': guid,
				'url': url,
				'title': title,
				'width_image': width_image,
				'height_image': height_image,
				'image': image,
				'alt_image': alt_image,
				'description': description,
				'date_publication': date_publication,
				'author': author }
		}).done(function() {

		resetItem();
		loadItems();

	});
}

function deleteItem(button) {

	var id = $(button).parent().parent().attr('item_id');

	$.ajax({
		url : '/application/admin/modules/item/php/controller/item.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'deleteItem', 
				'id': id }
		}).done(function() {

		resetItem();
		loadItems();

	});
}

function createItem() {

	var type_item_id = $(".informations-item-new select[id=type-item-select] option:selected").val();
	var website_category_id = $(".informations-item-new select[id=website-category-select] option:selected").val();
	var url = $(".informations-item-new input[id=url]").val();
	var title = $(".informations-item-new input[id=title]").val();
	var width_image = $(".informations-item-new input[id=width_image]").val();
	var height_image = $(".informations-item-new input[id=height_image]").val();
	var image = $(".informations-item-new input[id=image]").val();
	var alt_image = $(".informations-item-new input[id=alt_image]").val();
	var description = $(".informations-item-new input[id=description]").val();
	var date_publication = $(".informations-item-new input[id=date_publication]").val();
	var author = $(".informations-item-new input[id=author]").val();

	$.ajax({
		url : '/application/admin/modules/item/php/controller/item.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'createItem',
				'type_item_id': type_item_id,
				'website_category_id': website_category_id,
				'url': url,
				'title': title,
				'width_image': width_image,
				'height_image': height_image,
				'image': image,
				'alt_image': alt_image,
				'description': description,
				'date_publication': date_publication,
				'author': author }
		}).done(function() {

		resetItem();
		loadItems();

	});

}


///// Fonction système
function loadUploader() {

	settings = {
	    url: "/application/admin/php/controller/upload.controller.php",
	    dragDrop:false,
	    multiple:false,
		autoSubmit:true,
	    fileName: "myfile",
	    formData: {"type":"item", "action":"set"},
	    allowedTypes:"jpg,jpeg",	
	    returnType:"json",
		onSuccess:function(files,data,xhr)
	    {
	       image = "/application/ressources/item/" + data.toString();
	       $('.informations-item-new input[id=image]').val(image);

	        delay(function(){
	       		$(".ajax-file-upload-statusbar").empty().remove();
			}, 5000);
	    },
	    showDelete:false
	}
	uploadObj = $(".informations-item-new div[id=multiplefileuploader_image]").uploadFile(settings);

}

function resetItem() {

	settings = null;
	uploadObj = null;
	$(".ajax-file-upload").empty().remove();
	$(".ajax-file-upload-statusbar").empty().remove();

	loadUploader();

	$(".informations-item-new select[id=type-item-select]").empty();
	$(".informations-item-new select[id=website-category-select]").empty();
	$(".informations-item-new input[id=url]").val('');
	$(".informations-item-new input[id=title]").val('');
	$(".informations-item-new input[id=width_image]").val('');
	$(".informations-item-new input[id=height_image]").val('');
	$(".informations-item-new input[id=image]").val('');
	$(".informations-item-new input[id=alt_image]").val('');
	$(".informations-item-new input[id=description]").val('');
	$(".informations-item-new input[id=date_publication]").val('');
	$(".informations-item-new input[id=author]").val('');
}
