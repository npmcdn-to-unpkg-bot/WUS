$(".subscription").off('click');
$(".subscription").on('click', function() {

    subscription($(this));

});

$(".unsubscription").off('click');
$(".unsubscription").on('click', function() {

    unsubscription($(this));

});

function subscription(element) {
    var website_id = $(element).attr('website_id');

    console.log(website_id);

    $.ajax({
        url: "application/web/ajax/controller.subscription.php",
        type: 'POST',
        data: {'action':'subscription', 'website_id':website_id}
    }).done(function(response) {
        // Puis appeler la fonction de rechargement ajax de
        // la timeline qui ira chercher les cookies en cours.
        console.log('enr choice');
        //loadTimeline();
        location.reload();
    });
}

function unsubscription(element) {

    var website_id = $(element).attr('website_id');

    console.log(website_id);

    $.ajax({
        url: "application/web/ajax/controller.subscription.php",
        type: 'POST',
        data: {'action':'unsubscription', 'website_id':website_id}
    }).done(function(response) {
        // Puis appeler la fonction de rechargement ajax de
        // la timeline qui ira chercher les cookies en cours.
        console.log('enr choice');
        //loadTimeline();
        location.reload();
    });   
}