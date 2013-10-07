
$(document).ready(function() {

    $('.nav-link').removeClass('active');
    $('.nl-' + $('#current-page').html()).addClass('active');
    $('#nls-' + $('#current-subpage').html()).addClass('active');

    var sidebarHidden = true;

    $('#btn-toggle-sidebar').click(function(e) {
        e.preventDefault();
        console.log(sidebarHidden);
        if (sidebarHidden) {
            $('.sidebar-content').show({
                done: function() {
                    sidebarHidden = false;
                }
            });
        } else {
            $('.sidebar-content').hide({
                done: function() {
                    sidebarHidden = true;
                }
            });
        }
    });

    var currentPage = $('#current-page').html();

    if (currentPage === 'news') {
        var number = $('#news-number').html();
        $.ajax({
            type: 'GET',
            url: Routing.generate('korpus_api_news_collection') + '/' + number
        }).done(function(data) {
            var source = $('#news-post-template').html();
            var template = Handlebars.compile(source);
            $('.news-post').html(template(data));
        }).fail(function() {

        });
    }

});

Handlebars.registerHelper('moment', function(date) {
    if (date === null || date === 'undefined' || date === "" || date === undefined)
        return "-";
    return moment(date).format('Do MMMM YYYY, h:mm:ss a');
});

Handlebars.registerHelper('moment_small', function(date) {
    if (date === null || date === 'undefined' || date === "" || date === undefined)
        return "-";
    return moment(date).format('DD.MM.YY');
});

Handlebars.registerHelper('markdown', function(input) {
    return new Handlebars.SafeString(input);
});