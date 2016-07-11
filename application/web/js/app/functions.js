$(".container-functions .home").off('click');
$(".container-functions .home").on('click', function() {

    $(".medias").show();
    $(".search-info").hide();
    $(".articles").show();
    $(".recherche").hide();
    $(this).addClass('active');
    $(".container-functions .search").removeClass('active');
});

$(".container-functions .search").off('click');
$(".container-functions .search").on('click', function() {

    $(".medias").hide();
    $(".search-info").show();
    $(".recherche").show();
    $(".articles").hide();
    $(this).addClass('active');
    $(".container-functions .home").removeClass('active');
});