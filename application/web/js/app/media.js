$(".media_choice").off('click');
$(".media_choice").on('click', function() {

    // Rechercher tout les medias selectionné
    // pour les mettre dans un tableau envoyé une 
    // fonction qui set les cookies.
    var medias_id = Array();

    $.each($(this).parent().parent().find('li.container-subscription input[type=checkbox]:checked'), function(index, value) {
        medias_id.push($(value).attr('website_id'));
    });

    console.log(medias_id);

    $.ajax({
        url: "application/web/ajax/controller.media.php",
        type: 'POST',
        data: {'action':'setMediaInCookies', 'medias_id':medias_id}
    }).done(function(response) {
        // Puis appeler la fonction de rechargement ajax de
        // la timeline qui ira chercher les cookies en cours.
        console.log('enr choice');
        loadTimeline();
    });

});