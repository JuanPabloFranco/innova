$(function() {
    $('[data-toggle="tooltip"]').tooltip()
});
$(document).ready(function() {
    var colorPalette = ['000000', 'FF9966', '6699FF', '99FF66', 'CC0000', '00CC00', '0000CC', '333333', '0066FF', 'FFFFFF'],
        forePalette = $('.fore-palette'),
        backPalette = $('.back-palette'),
        editor = $('.editor');

    for (var i = 0; i < colorPalette.length; i++) {
        forePalette.append('<a href="#" data-command="foreColor" data-value="' + '#' + colorPalette[i] + '" style="background-color:' + '#' + colorPalette[i] + ';" class="palette-item"></a>');
        backPalette.append('<a href="#" data-command="backColor" data-value="' + '#' + colorPalette[i] + '" style="background-color:' + '#' + colorPalette[i] + ';" class="palette-item"></a>');
    }
    $('.toolbar a').click(function(e) {
        e.preventDefault();
        var command = $(this).data('command');
        if (command == 'h1' || command == 'h2' || command == 'p') {
            document.execCommand('formatBlock', false, command);
        }
        if (command == 'foreColor' || command == 'backColor') {
            var color = $(this).data('value');
            document.execCommand($(this).data('command'), false, color);
        }
        if (command == 'removeFormat') {
            document.execCommand('removeFormat', false, command);
        }
        if (command == 'createlink' || command == 'insertimage') {
            url = prompt('Enter the link here: ', 'http:\/\/');
            console.log(command + " " + url);
            document.execCommand($(this).data('command'), false);
            // document.execCommand($(this).data('command') && 'enableObjectResizing', false, url);
        } else document.execCommand($(this).data('command'), false);
    });
    $('.editorAria img').click(function() {
        document.execCommand('enableObjectResizing', false);
    });
    $("#getHTML").click(function() {
        var editorId = $(this).attr('get-data');
        var html = $("#" + editorId).find('.editorAria').html();
    });
});