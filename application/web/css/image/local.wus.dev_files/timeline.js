function loadTimeline() {
	$.ajax({
        url: "application/web/ajax/controller.timeline.php",
        type: 'POST',
        data: {'action':'loadTimeline'},
    }).done(function(response) {
    	$('.timeline').empty().html(response);
    });
}