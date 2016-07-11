
$('.searching').off('click');
$('.searching').on('click', function(e) {
    Search();
});

$('.pagination-search').off('click');
$('.pagination-search').on('click', function(e) {
    SetPage($(this));
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

            ResetPage();

            if(data !== "") {
                $('.result-searching').empty().html(data);
                //$('.result-searching').fadeIn(300);

                $('.pagination-search').off('click');
                $('.pagination-search').on('click', function(e) {
                    SetPage($(this));
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

function SetPage(object) {

    var page = $(object).attr('nbpage');

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

function ResetPage() {

    $.ajax({
        url: "application/web/ajax/controller.search.php",
        type: "POST",        
        data: { 
            'action' : 'setPage',
            'page' : 1
        },
        success: function(data) {
        }
    }).done(function(data) {
    }).fail(function( jqXHR, textStatus ) {
    });
}