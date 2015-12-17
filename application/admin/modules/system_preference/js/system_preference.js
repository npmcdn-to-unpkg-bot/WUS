// step 1 js

//show step1 by default
$('#system-preference-page').fadeIn('slow');

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
resetSystemPreference();

/**
 * Load categories
 */
loadSystemPreferences();


/**
 * @return {json data}
 */
function loadSystemPreferences() {

	$.ajax({
		url: '/application/admin/modules/system_preference/php/controller/system_preference.controller.php',
		type: 'POST',
		data: {'action':'getSystemPreference'},
		success: function(response) {
			
			var data = $.parseJSON(response);

			$(".informations-system-preference input[id=url_facebook]").val(data.url_facebook);
			$(".informations-system-preference input[id=url_instagram]").val(data.url_instagram);
			$(".informations-system-preference input[id=url_twitter]").val(data.url_twitter);
			$(".informations-system-preference input[id=url_rss]").val(data.url_rss);
			$(".informations-system-preference input[id=url_sitemap]").val(data.url_sitemap);
			$(".informations-system-preference input[id=counter_carrousel]").val(data.counter_carrousel);
		}
	}).done(function () {
	});

	$('#update_system_preference').off('click');
	$('#update_system_preference').on('click', function() {
		editSystemPreference();
	});
}

function editSystemPreference() {

	var url_facebook = $(".informations-system-preference input[id=url_facebook]").val();
	var url_instagram = $(".informations-system-preference input[id=url_instagram]").val();
	var url_twitter = $(".informations-system-preference input[id=url_twitter]").val();
	var url_rss = $(".informations-system-preference input[id=url_rss]").val();
	var url_sitemap = $(".informations-system-preference input[id=url_sitemap]").val();
	var counter_carrousel = $(".informations-system-preference input[id=counter_carrousel]").val();

	$.ajax({
		url : '/application/admin/modules/system_preference/php/controller/system_preference.controller.php', // La ressource ciblée
		type : 'POST', // Le type de la requête HTTP
		data : { 'action': 'editSystemPreference', 
				'url_facebook': url_facebook,
				'url_instagram': url_instagram,
				'url_twitter': url_twitter,
				'url_rss': url_rss,
				'url_sitemap': url_sitemap,
				'counter_carrousel': counter_carrousel }
		}).done(function() {

		resetSystemPreference();
		loadSystemPreferences();

	});

}


///// Fonction système

function resetSystemPreference() {

	$(".informations-system-preference input[id=url_facebook]").val('');
	$(".informations-system-preference input[id=url_instagram]").val('');
	$(".informations-system-preference input[id=url_twitter]").val('');
	$(".informations-system-preference input[id=url_rss]").val('');
	$(".informations-system-preference input[id=url_sitemap]").val('');
	$(".informations-system-preference input[id=counter_carrousel]").val('');
}
