function filterSpecialChars(str) {
    return str.replace(/[^\w\s]/gi, '-');
};

function generateEventSlug(str) {
    str = str.replace(/ /g, '-');
    str = filterSpecialChars(str);
    str = str.toLowerCase();
    return str;
};

$(document).ready(function () {
    var currentPage = $('#current-page').html();

    $('.nav-link').removeClass('active');
    $('#nl-' + currentPage).addClass('active');

    //EVENTS
    $('#toggle-viewable').click(function (e) {
        e.preventDefault();
        $.post(Routing.generate('korpus_admin_panel_events_toggle_viewable', {
            id: $(this).data('id')
        }), function (data) {
            location.reload();
        });
    });

    $('#toggle-reservable').click(function (e) {
        e.preventDefault();
        $.post(Routing.generate('korpus_admin_panel_events_toggle_reservable', {
            id: $(this).data('id')
        }), function (data) {
            location.reload();
        });
    });

    //events slug
    $('#event-input-title').keyup(function () {
        $('#event-input-slug').val(generateEventSlug($(this).val()));
    });

    $('#event-input-title').focusout(function () {
        $('#event-input-slug').val(generateEventSlug($(this).val()));
    });

    //event datepicker
    $('#input-event-date').datepicker();

});
