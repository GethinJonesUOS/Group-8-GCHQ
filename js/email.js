$(document).ready(function() {
    $.post("email.php", { getscroll: true })
        .done(function (data) {
            $('#email-list').scrollTop(data['scrollPos']);
        });

    $('#email-list').scroll(function() {
        $.post("email.php", { setscroll: $('#email-list').scrollTop() });
    });

    $('[url]').mouseover(function () {
        $('#status').html(($(this).attr('url')));
    });

    $('[url]').mouseout(function () {
        $('#status').html('&nbsp;');
    });

    [].slice.call(document.querySelectorAll('[hint]')).map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {html: true, toggle: 'tooltip', placement: 'auto', boundary: '#email-client'})
    })
});