
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
    var url = Routing.generate('korpus_file_server_images_collection_thumbs', {
        folder: folder
    }, true);

    $.get(url).success(function(data) {
        var images = data;

        if (images === null) {
            $('#select-images-one').html('<strong>Keine Bilder verfügbar</strong>');
        } else {
            var text = '<div class="form-group div-image-select"><select id="images-select" class="form-control" name="sel_image">';

            text += '<option value="" selected>';

            $.each(images, function(key, image) {
                text += '<option data-img-label="' + image.title + '" data-img-src="' + image.path + '" value="' + image.hash + '">';
            });

            text += '</select></div>';

            $('#select-images-one').html(text);
            $('#images-select').livequery(function() {
                var self = $(this);
                $(this).imagepicker({
                    show_label: true,
                    selected: function() {
                        $('#img-hash').val(self.val());
                    }
                });
            });
        }
    });

};

$(document).ready(function() {

    var currsub = $('#current-subpage').html();

    $('.nav-link').removeClass('active');
    $('.nl-' + $('#current-page').html()).addClass('active');
    $('#nls-' + $('#current-subpage').html()).addClass('active');

    if (currsub === 'concert') {
        refreshImages('concert');
    } else if (currsub === 'record') {
        refreshImages('records');
    } else if (currsub === 'member') {
        refreshImages('band');
    } else if (currsub === 'news') {
        refreshImages('news');
    } else if (currsub === 'article') {
        refreshImages('shop');
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

    /*$('button[type="submit"]').addClass('btn').addClass('btn-success');*/

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

            if (currsub === 'concert') {
                refreshImages('concert');
            } else if (currsub === 'record') {
                refreshImages('records');
            } else if (currsub === 'member') {
                refreshImages('band');
            } else if (currsub === 'news') {
                refreshImages('news');
            } else if (currsub === 'article') {
                refreshImages('shop');
            }
        });
    });

    $('#toggle-filetypegroups').click(function(e) {
        e.preventDefault();
        var status = $('#section-filetypegroups').css('display');

        if (status === 'block') {
            $('#section-filetypegroups').fadeOut();
            $(this).children('span.glyphicon').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
        }
        if (status === 'none') {
            $('#section-filetypegroups').fadeIn();
            $(this).children('span.glyphicon').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
        }
    });

    $('#toggle-filetypes').click(function(e) {
        e.preventDefault();
        var status = $('#section-filetypes').css('display');

        if (status === 'block') {
            $('#section-filetypes').fadeOut();
            $(this).children('span.glyphicon').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
        }
        if (status === 'none') {
            $('#section-filetypes').fadeIn();
            $(this).children('span.glyphicon').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
        }
    });

    //EVENTS
    $('#toggle-viewable').click(function(e) {
        e.preventDefault();
        $.post(Routing.generate('korpus_console_events_toggle_viewable', {
            slug: $(this).data('slug')
        }), function(data) {
            location.reload();
        });
    });

    $('#toggle-reservable').click(function(e) {
        e.preventDefault();
        $.post(Routing.generate('korpus_console_events_toggle_reservable', {
            slug: $(this).data('slug')
        }), function(data) {
            location.reload();
        });
    });

});