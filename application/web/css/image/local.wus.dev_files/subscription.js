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
        //location.reload();
        $(".subscription").each(function() {
            if($(this).attr('website_id') == website_id) {
                $(this).removeClass('subscription').addClass('unsubscription');

                $(".unsubscription").off('click');
                $(".unsubscription").on('click', function(e) {

                    e.preventDefault();
                    unsubscription($(this));

                });
            }
        });
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
        //location.reload();
        $(".unsubscription").each(function() {
            if($(this).attr('website_id') == website_id) {
                $(this).removeClass('unsubscription').addClass('subscription');

                $(".subscription").off('click');
                $(".subscription").on('click', function(e) {

                    e.preventDefault();

                    subscription($(this));

                });
            }
        });
    });   
}