
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

    $("#slide1").googleslides({
        userid: '115528839112598673902',
        albumid: '5710317752556741025',
        imgmax: $('.content-area').width()
    });

});