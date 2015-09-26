$(".precedent a").off('click');
$(".precedent a").on('click', function() {

    var id = $(this).parent().parent().parent().parent().attr('id');
    var counter = $(this).parent().parent().parent().parent().attr('counter');
    var counter_min = 1;
    var counter_max = $('html').find('caroussel').attr('data-element');

    if(counter == counter_min)
    {
    	$('#' + id).hide("slide", { direction: "right" }, 'slow');
    	$('#caroussel_' + counter_max).show("slide", { direction: "left" }, 'slow');
    }
    else
    {
    	$('#' + id).hide("slide", { direction: "right" }, 'slow');
    	var new_counter = parseInt(counter) - 1;
    	$('#caroussel_' + new_counter).show("slide", { direction: "left" }, 'slow');
    }
});

$(".suivant a").off('click');
$(".suivant a").on('click', function() {

    var id = $(this).parent().parent().parent().parent().attr('id');
    var counter = $(this).parent().parent().parent().parent().attr('counter');
    var counter_min = 1;
    var counter_max = $('html').find('caroussel').attr('data-element');

    if(counter == counter_max)
    {
    	$('#' + id).toggle('slide', {direction: 'left'}, 'slow');
    	$('#caroussel_' + counter_min).toggle('slide', {direction: 'right'}, 'slow');    	
    }
    else
    {
    	$('#' + id).toggle('slide', {direction: 'left'}, 'slow');
    	var new_counter = parseInt(counter) + 1;
    	$('#caroussel_' + new_counter).toggle('slide', {direction: 'right'}, 'slow');
    }
});
