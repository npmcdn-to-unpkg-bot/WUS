
$('.searching').off('click');
$('.searching').on('click', function(e) {
    Search();
});

$('.pagination-search').off('click');
$('.pagination-search').on('click', function(e) {
    SetPage();
});

function Search() {
    var searched = $('.searched').val();

    $.ajax({
        url: "application/web/ajax/controller.search.php",
        type: "POST",        
        data: { 
            'action' : 'search',
            'searched' : searched
        },
        success: function(data) {

            if(data !== "") {
                $('.result-searching').empty().html(data);
                $('.result-searching').fadeIn(300);

                $('.pagination-search').off('click');
                $('.pagination-search').on('click', function(e) {
                    SetPage();
                });
            }
            else {
                $('.result-searching').fadeOut(0);
            }
        }
    }).done(function(data) {
    }).fail(function( jqXHR, textStatus ) {
    });
}

function SetPage() {

    var page = $('.pagination-search').attr('data-page');

    $.ajax({
        url: "application/web/ajax/controller.search.php",
        type: "POST",        
        data: { 
            'action' : 'setPage',
            'page' : page
        },
        success: function(data) {
            Search();
        }
    }).done(function(data) {
    }).fail(function( jqXHR, textStatus ) {
    });
}