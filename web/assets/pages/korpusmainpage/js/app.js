
$(document).ready(function() {

    $('.nav-link').removeClass('active');
    $('.nl-' + $('#current-page').html()).addClass('active');
    $('#nls-' + $('#current-subpage').html()).addClass('active');

    $('#share-btn').click(function(e) {
        e.preventDefault();
        window.open($(this).attr('href'), 'sharer', 'width=626,height=436');
    });

    if ($('#current-page').html() === 'news') {
        $('.news-post img').addClass('img-responsive').addClass('img-thumbnail');
    }

    //cmoa 11
    $("#slide1").googleslides({
        userid: '116997391993592039168',
        albumid: '5945065822900542385',
        imgmax: $('.content-area').width()
    });
    
    //hd 13
    $("#slide2").googleslides({
        userid: '116997391993592039168',
        albumid: '5945071918379232177',
        imgmax: $('.content-area').width()
    });
    
    //sni 13
    $("#slide3").googleslides({
        userid: '116997391993592039168',
        albumid: '5945073303979243089',
        imgmax: $('.content-area').width()
    });
    
    $.facebox.settings.closeImage = $('#fbox-closelabel').html();
    $.facebox.settings.loadingImage = $('#fbox-loading').html();

    $('a[rel*=soundcloud-facebox]').facebox();

});