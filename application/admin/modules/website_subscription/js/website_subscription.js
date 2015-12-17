// step 1 js

//show step1 by default
$('#website-subscription-page').fadeIn('slow');

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
resetWebsiteSubscription();

/**
 * Load categories
 */
loadWebsiteSubscriptions();


/**
 * @return {json data}
 */
function loadWebsiteSubscriptions() {

	$.ajax({
		url: '/application/admin/modules/website_subscription/php/controller/website_subscription.controller.php',
		type: 'POST',
		data: {'action':'getAllWebsiteSubscriptionsDT'},
		success: function(response) {
			$("#dt_website_subscriptions").empty().html(response);
		}
	}).done(function () {

		var table = $('#dt_website_subscriptions').DataTable();
		table.destroy();

		$("#dt_website_subscriptions").dataTable( {
	        scrollY: "400px",
			scrollCollapse: true,
			paging: false,
			searching: false
	    });

	    $('.delete_website_subscription_dt').off('click');
		$('.delete_website_subscription_dt').on('click', function() {
			deleteWebsiteSubscription($(this));
		});

		$('.edit_website_subscription_dt').off('click');
		$('.edit_website_subscription_dt').on('click', function() {
			editWebsiteSubscription($(this));
		});
	});

	$('#create_website_subscription').off('click');
	$('#create_website_subscription').on('click', function() {
		createWebsiteSubscription();
	});

	$('#reset_website_subscription').off('click');
	$('#reset_website_subscription').on('click', function() {
		resetWebsiteSubscription();
	});

	$.ajax({
		url: '/application/admin/modules/website_subscription/php/controller/website_subscription.controller.php',
		type: 'POST',
		data: {'action':'getAllUsers'},
		success: function(response) {
			$("#user-select").empty().html(response);
		}
	}).done(function () {
	});

	$.ajax({
		url: '/application/admin/modules/website_subscription/php/controller/website_subscription.controller.php',
		type: 'POST',
		data: {'action':'getAllWebsites'},
		success: function(response) {
			$("#website-select").empty().html(response);
		}
	}).done(function () {
	});
}

function editWebsiteSubscription(button) {

	var id = $(button).parent().parent().attr('website_subscription_id');
	var user_id = $(button).parent().parent().find('.select_dt_user_id option:selected').val();
	var website_id = $(button).parent().parent().find('.select_dt_website_id option:selected').val();

	$.ajax({
		url : '/application/admin/modules/website_subscription/php/controller/website_subscription.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'editWebsiteSubscription', 
				'id': id,
				'user_id': user_id,
				'website_id': website_id }
		}).done(function() {

		resetWebsiteSubscription();
		loadWebsiteSubscriptions();

	});
}

function deleteWebsiteSubscription(button) {

	var id = $(button).parent().parent().attr('website_subscription_id');

	$.ajax({
		url : '/application/admin/modules/website_subscription/php/controller/website_subscription.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'deleteWebsiteSubscription', 
				'id': id }
		}).done(function() {

		resetWebsiteSubscription();
		loadWebsiteSubscriptions();

	});
}

function createWebsiteSubscription() {

	var user_id = $(".informations-website-subscription-new select[id=user-select] option:selected").val();
	var website_id = $(".informations-website-subscription-new select[id=website-select] option:selected").val();

	$.ajax({
		url : '/application/admin/modules/website_subscription/php/controller/website_subscription.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'createWebsiteSubscription', 
				'user_id': user_id,
				'website_id': website_id }
		}).done(function() {

		resetWebsiteSubscription();
		loadWebsiteSubscriptions();

	});

}


///// Fonction système

function resetWebsiteSubscription() {

	$(".informations-website-subscription-new input[id=user-select] option:first").prop('selected', true);
	$(".informations-website-subscription-new input[id=website-select] option:first").prop('selected', true);
}
