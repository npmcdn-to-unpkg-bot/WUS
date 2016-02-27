$(document).ready(function() {
    
    var time = $('.redirection-time').attr('time');

    var timer = 0;

    var handle = null;

    handle = setInterval(function() {

        if(timer >= 0 && timer < time) {
            $('.redirection-time').text(time - timer);
            timer += 1;
            return;
        }

        if(timer == time) {
            handle = null;
            $(location).attr('href',"/");
        }
    }, 1000);

});