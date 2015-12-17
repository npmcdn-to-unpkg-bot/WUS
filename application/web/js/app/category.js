$(".category_choice").off('click');
$(".category_choice").on('click', function() {

    // Rechercher toute les categories selectionné
    // pour les mettre dans un tableau envoyé une 
    // fonction qui set les cookies.
    var categories_id = Array();

    $.each($(this).parent().parent().find('category input[type=checkbox]:checked'), function(index, value) {
        categories_id.push($(value).attr('category_id'));
    });

    console.log(categories_id);

    $.ajax({
        url: "application/web/ajax/controller.category.php",
        type: 'POST',
        data: {'action':'setCategoryInCookies', 'categories_id':categories_id}
    }).done(function(response) {
        // Puis appeler la fonction de rechargement ajax de
        // la timeline qui ira chercher les cookies en cours.
        
        console.log(response);

        if(response) {
            loadTimeline();
        }
    });

});