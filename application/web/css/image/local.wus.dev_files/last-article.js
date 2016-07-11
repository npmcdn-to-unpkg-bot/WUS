function loadLastArticle() {
	$.ajax({
        url: "application/web/ajax/controller.last_article.php",
        type: 'POST',
        data: {'action':'lastArticle'},
    }).done(function(response) {
    	$('.last-article').empty().append(response).fadeIn(300);
    });
}