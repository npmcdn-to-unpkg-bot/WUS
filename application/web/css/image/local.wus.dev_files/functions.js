$(".functions .home").off('click');
$(".functions .home").on('click', function() {

    $(".medias").show();
    $(".search-info").hide();
    $(".articles").addClass('active');
    $(".recherche").removeClass('active');
    $(this).addClass('active');
    $(".functions .search").removeClass('active');
});

$(".functions .search").off('click');
$(".functions .search").on('click', function() {

    $(".medias").hide();
    $(".search-info").show();
    $(".recherche").addClass('active');
    $(".articles").removeClass('active');
    $(this).addClass('active');
    $(".functions .home").removeClass('active');
});