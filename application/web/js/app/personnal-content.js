$('.last-article-link').off('click');
$('.last-article-link').on('click', function() {
    
	$('.subscriptions-list-link').removeClass('active');
	$(this).addClass('active');

	$.ajax({
        url: "application/web/ajax/controller.last_article.php",
        type: 'POST',
        data: {'action':'lastArticle'}
    }).done(function(response) {
        
        $('.subscriptions-list').fadeOut(300);
    	$('.last-article').empty().append(response).fadeIn(300);

    });

    return false;

});

$('.subscriptions-list-link').off('click');
$('.subscriptions-list-link').on('click', function() {
    
	$('.last-article-link').removeClass('active');
	$(this).addClass('active');

	$.ajax({
        url: "application/web/ajax/controller.subscription.php",
        type: 'POST',
        data: {'action':'subscriptionList'}
    }).done(function(response) {
        
    	$('.last-article').fadeOut(300);
    	$('.subscriptions-list').empty().append(response).fadeIn(300);

    	$(".subscription").off('click');
		$(".subscription").on('click', function(e) {

		    e.preventDefault();

		    subscription($(this));

		});

		$(".unsubscription").off('click');
		$(".unsubscription").on('click', function(e) {

		    e.preventDefault();
		    unsubscription($(this));

		});

    });

    return false;

});