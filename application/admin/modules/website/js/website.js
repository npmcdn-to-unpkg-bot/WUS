// step 1 js

//show step1 by default
$('#website-page').fadeIn('slow');

// var global
var logo = null;

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
resetWebsite();

/**
 * Load websites
 */
loadWebsites();


/**
 * @return {json data}
 */
function loadWebsites() {

	$.ajax({
		url: '/application/admin/modules/website/php/controller/website.controller.php',
		type: 'POST',
		data: {'action':'getAllWebsitesDT'},
		success: function(response) {
			$("#dt_websites").empty().html(response);
		}
	}).done(function () {

		var table = $('#dt_websites').DataTable();
		table.destroy();

		$("#dt_websites").dataTable( {
	        scrollY: "400px",
			scrollCollapse: true,
			paging: false,
			searching: false,
			rowCallback: function ( row, data ) {
	            // Set the checked state of the checkbox in the table
	            $('input.input_dt_scrap', row).prop( 'checked', $('input.input_dt_scrap', row).val() == 1 );
	        }
	    });

	    $('.delete_website_dt').off('click');
		$('.delete_website_dt').on('click', function() {
			deleteWebsite($(this));
		});

		$('.edit_website_dt').off('click');
		$('.edit_website_dt').on('click', function() {
			editWebsite($(this));
		});
	});

	$('#create_website').off('click');
	$('#create_website').on('click', function() {
		createWebsite();
	});

	$('#reset_website').off('click');
	$('#reset_website').on('click', function() {
		resetWebsite();
	});
}

function editWebsite(button) {

	var id = $(button).parent().parent().attr('websiteId');
	var website = $(button).parent().parent().find('.input_dt_website').val();
	var url = $(button).parent().parent().find('.input_dt_url').val();
	var logo = $(button).parent().parent().find('.input_dt_logo').val();
	var file = $(button).parent().parent().find('.input_dt_file').val();
	var scrap = ($(button).parent().parent().find('.input_dt_scrap').prop('checked') == true ? 1 : 0);

	$.ajax({
		url : '/application/admin/modules/website/php/controller/website.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'editWebsite', 
				'id': id,
				'website': website,
				'url': url,
				'logo': logo,
				'file': file,
				'scrap': scrap }
		}).done(function() {

		resetWebsite();
		loadWebsites();

	});
}

function deleteWebsite(button) {

	var id = $(button).parent().parent().attr('websiteId');

	$.ajax({
		url : '/application/admin/modules/website/php/controller/website.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'deleteWebsite', 
				'id': id }
		}).done(function() {

		resetWebsite();
		loadWebsites();

	});
}

function createWebsite() {

	var website = $(".informations-website-new input[id=website]").val();
	var url = $(".informations-website-new input[id=url]").val();
	var logo = $(".informations-website-new input[id=logo]").val();
	var scrap = ($(".informations-website-new input[id=scrap]").attr('checked') == 1 ? true : false);

	var container = $(".configuration-website-new input[id=container]").val();
	
	var item_container = $(".configuration-website-new input[id=item-container]").val();
	
	var item_url_html = $(".configuration-website-new input[id=item-url-html]").val();
	var item_url_element = $(".configuration-website-new input[id=item-url-element]").val();

	var item_title_html = $(".configuration-website-new input[id=item-title-html]").val();
	var item_title_element = $(".configuration-website-new input[id=item-title-element]").val();
	
	var item_width_image_html = $(".configuration-website-new input[id=item-width_image-html]").val();
	var item_width_image_element = $(".configuration-website-new input[id=item-width_image-element]").val();

	var item_height_image_html = $(".configuration-website-new input[id=item-height_image-html]").val();
	var item_height_image_element = $(".configuration-website-new input[id=item-height_image-element]").val();
	
	var item_image_html = $(".configuration-website-new input[id=item-image-html]").val();
	var item_image_element = $(".configuration-website-new input[id=item-image-element]").val();

	var item_alt_image_html = $(".configuration-website-new input[id=item-alt_image-html]").val();
	var item_alt_image_element = $(".configuration-website-new input[id=item-alt_image-element]").val();
	
	var item_description_html = $(".configuration-website-new input[id=item-description-html]").val();
	var item_description_element = $(".configuration-website-new input[id=item-description-element]").val();

	var item_date_publication_html = $(".configuration-website-new input[id=item-date_publication-html]").val();
	var item_date_publication_element = $(".configuration-website-new input[id=item-date_publication-element]").val();
	
	var item_author_html = $(".configuration-website-new input[id=item-author-html]").val();
	var item_author_element = $(".configuration-website-new input[id=item-author-element]").val();

	var item_inner_date_publication_html = $(".configuration-website-new input[id=item_inner-date_publication-html]").val();
	var item_inner_date_publication_element = $(".configuration-website-new input[id=item_inner-date_publication-element]").val();
	var item_inner_date_publication_format = $(".configuration-website-new input[id=item_inner-date_publication-format]").val();
	
	var item_inner_date_publication_function_type = $(".configuration-website-new input[id=item_inner-date_publication-function-type]").val();
	var item_inner_date_publication_function_separator = $(".configuration-website-new input[id=item_inner-date_publication-function-separator]").val();
	var item_inner_date_publication_function_counter = $(".configuration-website-new input[id=item_inner-date_publication-function-counter]").val();

	alert(item_inner_date_publication_html);

	$.ajax({
		url : '/application/admin/modules/website/php/controller/website.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'createWebsite', 
				'website': website,
				'url': url,
				'logo': logo,
				'scrap': scrap,
				'container': container,
				'item-container': item_container,
				'item-url-html': item_url_html,
				'item-url-element': item_url_element,
				'item-title-html': item_title_html,
				'item-title-element': item_title_element,
				'item-width_image-html': item_width_image_html,
				'item-width_image-element': item_width_image_element,
				'item-height_image-html': item_height_image_html,
				'item-height_image-element': item_height_image_element,
				'item-image-html': item_image_html,
				'item-image-element': item_image_element,
				'item-alt_image-html': item_alt_image_html,
				'item-alt_image-element': item_alt_image_element,
				'item-description-html': item_description_html,
				'item-description-element': item_description_element,
				'item-date_publication-html': item_date_publication_html,
				'item-date_publication-element': item_date_publication_element,
				'item-author-html': item_author_html,
				'item-author-element': item_author_element,
				'item-inner-date-publication-html': item_inner_date_publication_html,
				'item-inner-date-publication-element': item_inner_date_publication_element,
				'item-inner-date-publication-format': item_inner_date_publication_format,
				'item-inner-date-publication-function-type': item_inner_date_publication_function_type,
				'item-inner-date-publication-function-separator': item_inner_date_publication_function_separator,
				'item-inner-date-publication-function-counter': item_inner_date_publication_function_counter }
		}).done(function() {

		resetWebsite();
		loadWebsites();

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
	    formData: {"type":"logo", "action":"set"},
	    allowedTypes:"jpg,jpeg",	
	    returnType:"json",
		onSuccess:function(files,data,xhr)
	    {
	       logo = "/application/ressources/logo/" + data.toString();
	       $('.informations-website-new input[id=logo]').val(logo);

	        delay(function(){
	       		$(".ajax-file-upload-statusbar").empty().remove();
			}, 5000);
	    },
	    showDelete:false
	}
	uploadObj = $(".informations-website-new div[id=multiplefileuploader_logo]").uploadFile(settings);

}

function resetWebsite() {
	settings = null;
	uploadObj = null;
	$(".ajax-file-upload").empty().remove();
	$(".ajax-file-upload-statusbar").empty().remove();

	loadUploader();

	$(".informations-website-new input[id=website]").val('');
	$(".informations-website-new input[id=url]").val('');
	$(".informations-website-new input[id=logo]").val('');
	$(".informations-website-new input[id=scrap]").attr('checked', false);

	$(".configuration-website-new input[id=container]").val('');
	$(".configuration-website-new input[id=item-container]").val('');
	$(".configuration-website-new input[id=item-url-html]").val('');
	$(".configuration-website-new input[id=item-url-element]").val('');
	$(".configuration-website-new input[id=item-title-html]").val('');
	$(".configuration-website-new input[id=item-title-element]").val('');
	$(".configuration-website-new input[id=item-width_image-html]").val('');
	$(".configuration-website-new input[id=item-width_image-element]").val('');
	$(".configuration-website-new input[id=item-height_image-html]").val('');
	$(".configuration-website-new input[id=item-height_image-element]").val('');
	$(".configuration-website-new input[id=item-image-html]").val('');
	$(".configuration-website-new input[id=item-image-element]").val('');
	$(".configuration-website-new input[id=item-alt_image-html]").val('');
	$(".configuration-website-new input[id=item-alt_image-element]").val('');
	$(".configuration-website-new input[id=item-description-html]").val('');
	$(".configuration-website-new input[id=item-description-element]").val('');
	$(".configuration-website-new input[id=item-date_publication-html]").val('');
	$(".configuration-website-new input[id=item-date_publication-element]").val('');
	$(".configuration-website-new input[id=item-author-html]").val('');
	$(".configuration-website-new input[id=item-author-element]").val('');

	/*$("input[type=checkbox]").off('click');
	$("input[type=checkbox]").on('click', function() {
		if($(this).is(':checked')) $(this).removeAttr('checked');
		else $(this).addAttr('checked');
	});*/
}
