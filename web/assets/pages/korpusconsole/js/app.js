
var addlink = function(text, url, title) {
    var tbox = $('#form_text');
    var currentContent = tbox.value();
    var link = '';

    if (title === '')
        link = '[' + text + '](' + url + ')';
    else
        link = '[' + text + '](' + url + ' "' + title + '")';

    tbox.value(currentContent + link);
};

var refreshImages = function(folder) {
    var url = 'http://localhost/github/korpus-metalde/web/app_dev.php/filesystem/images/thumbs/' + folder;
    $.get(url).success(function(data) {
        var images = data;

        if (images === null) {
            $('#select-images-one').html('<strong>Keine Bilder verfügbar</strong>');
        } else {
            var text = '<div class="form-group"><select id="images-select" class="form-control">';

            $.each(images, function(key, image) {
                console.log(image);
                text += '<option data-img-label="' + image.title + '" data-img-src="' + image.path + '" value="' + image.path + '">';
            });

            text += '</select></div>';

            $('#select-images-one').html(text);
            $('#images-select').livequery(function() {
                $(this).imagepicker({
                    show_label: true
                });
            });
        }
    });

};

$(document).ready(function() {

    $('.nav-link').removeClass('active');
    $('.nl-' + $('#current-page').html()).addClass('active');
    $('#nls-' + $('#current-subpage').html()).addClass('active');

    if ($('#current-subpage').html() === 'concert') {
        refreshImages('concert');
    }

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

    $('#form-img-upload').submit(function() {
        var self = $(this);

        $('iframe[name="upload-frame"]').load(function() {
            var response = $.parseJSON($(this).contents().text());

            if (response.status === 'error') {
                alertify.error(response.message);
            }

            self.each(function() {
                this.reset();
            });

            refreshImages('concert');
        });
    });

});