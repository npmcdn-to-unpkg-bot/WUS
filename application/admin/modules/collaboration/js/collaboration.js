// step 1 js

//show step1 by default
$('#collaboration-page').fadeIn('slow');

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
resetCollaboration();

/**
 * Load collaborations
 */
loadCollaborations();


/**
 * @return {json data}
 */
function loadCollaborations() {

	$.ajax({
		url: '/application/admin/modules/collaboration/php/controller/collaboration.controller.php',
		type: 'POST',
		data: {'action':'getAllCollaborationsDT'},
		success: function(response) {
			$("#dt_collaborations").empty().html(response);
		}
	}).done(function () {

		var table = $('#dt_collaborations').DataTable();
		table.destroy();

		$("#dt_collaborations").dataTable( {
	        scrollY: "400px",
			scrollCollapse: true,
			paging: false,
			searching: false
	    });

	    $('.delete_collaboration_dt').off('click');
		$('.delete_collaboration_dt').on('click', function() {
			deleteCollaboration($(this));
		});

		$('.edit_collaboration_dt').off('click');
		$('.edit_collaboration_dt').on('click', function() {
			editCollaboration($(this));
		});
	});

	$('#create_collaboration').off('click');
	$('#create_collaboration').on('click', function() {
		createCollaboration();
	});

	$('#reset_collaboration').off('click');
	$('#reset_collaboration').on('click', function() {
		resetCollaboration();
	});
}

function editCollaboration(button) {

	var id = $(button).parent().parent().attr('collaboration_id');
	var collaboration = $(button).parent().parent().find('.input_dt_collaboration').val();
	var url = $(button).parent().parent().find('.input_dt_url').val();
	var image = $(button).parent().parent().find('.input_dt_image').val();

	$.ajax({
		url : '/application/admin/modules/collaboration/php/controller/collaboration.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'editCollaboration', 
				'id': id,
				'collaboration': collaboration,
				'url': url,
				'image': image }
		}).done(function() {

		resetCollaboration();
		loadCollaborations();

	});
}

function deleteCollaboration(button) {

	var id = $(button).parent().parent().attr('collaboration_id');

	$.ajax({
		url : '/application/admin/modules/collaboration/php/controller/collaboration.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'deleteCollaboration', 
				'id': id }
		}).done(function() {

		resetCollaboration();
		loadCollaborations();

	});
}

function createCollaboration() {

	var collaboration = $(".informations-collaboration-new input[id=collaboration]").val();
	var url = $(".informations-collaboration-new input[id=url]").val();
	var image = $(".informations-collaboration-new input[id=image]").val();

	$.ajax({
		url : '/application/admin/modules/collaboration/php/controller/collaboration.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'createCollaboration', 
				'collaboration': collaboration,
				'url': url,
				'image': image }
		}).done(function() {

		resetCollaboration();
		loadCollaborations();

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
	    formData: {"type":"collaboration", "action":"set"},
	    allowedTypes:"jpg,jpeg",	
	    returnType:"json",
		onSuccess:function(files,data,xhr)
	    {
	       image = "/application/ressources/collaboration/" + data.toString();
	       $('.informations-collaboration-new input[id=image]').val(image);

	        delay(function(){
	       		$(".ajax-file-upload-statusbar").empty().remove();
			}, 5000);
	    },
	    showDelete:false
	}
	uploadObj = $(".informations-collaboration-new div[id=multiplefileuploader_logo]").uploadFile(settings);

}

function resetCollaboration() {

	settings = null;
	uploadObj = null;
	$(".ajax-file-upload").empty().remove();
	$(".ajax-file-upload-statusbar").empty().remove();

	loadUploader();

	$(".informations-collaboration-new input[id=collaboration]").val('');
	$(".informations-collaboration-new input[id=url]").val('');
	$(".informations-collaboration-new input[id=image]").val('');
}
