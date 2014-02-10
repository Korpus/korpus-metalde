$(document).ready(function () {
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
});
