
var addlink = function(text, url, title) {
    var tbox = $('#form_text');
    var currentContent = tbox.value();
    var link = '';

    if (title === '')
        link = '[' + text + '](' + url + ')';
    else
        link = '[' + text + '](' + url + ' "' + title + '")';

    tbox.value(currentContent + link);
}

$(document).ready(function() {

    $('.nav-link').removeClass('active');
    $('.nl-' + $('#current-page').html()).addClass('active');
    $('#nls-' + $('#current-subpage').html()).addClass('active');

    //news toolbox
    $('#btn-add-link').popover({
        html: true,
        placement: 'bottom',
        title: function() {
            return 'Link hinzufügen';
        },
        content: function() {
            return $('#add-link-content').html();
        }
    });

    $('form-add-link').livequery('submit', function(e) {
        e.preventDefault();
        var text = $(this).children('#input-add-link-text').value();
        var url = $(this).children('#input-add-link-url').value();
        var title = $(this).children('#input-add-link-title').value();

        if (text !== '' && url !== '') {
            addlink(text, url, title);
        } else {
            alertify.error('Text und URL dürfen nicht leer sein!');
        }
    });
    
    $('button[type="submit"]').addClass('btn').addClass('btn-success');

});