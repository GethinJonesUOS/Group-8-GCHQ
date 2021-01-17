let activeEmailID = -1;

let setupTooltips = function () {
    [].slice.call(document.querySelectorAll('[hint]')).map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl,
            { html: true,
                    toggle: 'tooltip',
                    placement: 'auto',
                    boundary: '#email-client'
                   });
    });

    $('[url]').mouseover(function () {
        $('#status').html(($(this).attr('url')));
    });

    $('[url]').mouseout(function () {
        $('#status').html('&nbsp;');
    });
}

$(document).ready(function() {
    setupTooltips();

    $('#email-count').text($('.email-card').length);

    $.post('email.php', {action: 'scoreslist'}).done(function (data) {
        let answerCount = 0;
        $.each(data, function (i, obj) {
            let card = $('[email-id=' + i + ']').find('.card-header');
            if (obj == 'real') {
                bgColorClassAdd = 'bg-success';
            } else if (obj == 'phishing') {
                bgColorClassAdd = 'bg-danger';
            }
            card.addClass(bgColorClassAdd);
            answerCount++;
        });
        $('#answer-count').text(answerCount);
    });

    $('.email-card').click(function () {
        let newEmailID = $(this).attr('email-id');

        $('#email-body').load('email.php?emailbody='.concat(newEmailID),
            function() {
                setupTooltips();
            });

        $.post('email.php', {selected: newEmailID}).done(function (data) {
            $('#selected-from-name').html(data['fromName']);
            $('#selected-from').html(data['from']);
            $('#selected-subject').html(data['subject']);
            $('[email-id='.concat(newEmailID).concat(']')).find('.card-body').addClass('bg-info');

        });

        $('#answer-form').show();
        if (activeEmailID >= 0 && activeEmailID != newEmailID) {
            $('[email-id='.concat(activeEmailID).concat(']')).find('.card-body').removeClass('bg-info');
        }

        $.post('email.php', {action: 'useranswer', id: newEmailID}).done(function (data) {
            let realLabel = $('#radio-real-label');
            let phishingLabel = $('#radio-phishing-label');

            if (data.answer === 'real') {
                realLabel.removeClass('btn-outline-success');
                realLabel.addClass('btn-success');
                phishingLabel.removeClass('btn-danger');
                phishingLabel.addClass('btn-outline-danger');
            } else if (data.answer == 'phishing') {
                realLabel.removeClass('btn-success');
                realLabel.addClass('btn-outline-success');
                phishingLabel.removeClass('btn-outline-danger');
                phishingLabel.addClass('btn-danger');
            } else {
                realLabel.removeClass('btn-success');
                realLabel.addClass('btn-outline-success');
                phishingLabel.removeClass('btn-danger');
                phishingLabel.addClass('btn-outline-danger');
            }
        });

        activeEmailID = newEmailID;

    });

    $('input[name=answer]:radio').click(function () {
        $('#answer-form').submit();
    });

    $('#answer-form').submit(function(event) {
        event.preventDefault();
        let selectedNode = $('input[name=answer]:radio:checked');
        let selectedAnswer = selectedNode.val();
        $.post('email.php', {answeremail: activeEmailID, answer: selectedAnswer}).done(function (data) {
            let bgColorClassAdd;
            let bgColorClassRem;

            let realLabel = $('#radio-real-label');
            let phishingLabel = $('#radio-phishing-label');

            if (selectedAnswer == 'phishing') {
                bgColorClassAdd = 'bg-danger';
                bgColorClassRem = 'bg-success';

                realLabel.removeClass('btn-success');
                realLabel.addClass('btn-outline-success');
                phishingLabel.removeClass('btn-outline-danger');
                phishingLabel.addClass('btn-danger');
            } else {
                bgColorClassAdd = 'bg-success';
                bgColorClassRem = 'bg-danger';

                realLabel.removeClass('btn-outline-success');
                realLabel.addClass('btn-success');
                phishingLabel.removeClass('btn-danger');
                phishingLabel.addClass('btn-outline-danger');
            }
            let cardHeader = $('[email-id='.concat(activeEmailID).concat(']')).find('.card-header');
            cardHeader.removeClass(bgColorClassRem);
            cardHeader.addClass(bgColorClassAdd);

            if (data.emailCount == data.answerCount) {
                $('#answer-submit').prop('disabled', false);
            }
            $('#answer-count').text(data.answerCount);
            $('#email-count').text(data.emailCount);
        });
    });

    $('#answer-reset').click(function() {
        $.post('email.php', {reset: 'true'}).done(function (data) {
            let arr = $('.email-card').find('.card-header');
            $.map(arr, function (n, i) {
                $(n).removeClass('bg-danger');
                $(n).removeClass('bg-success');
            });
            $('#answer-submit').prop('disabled', true);
            $('#answer-count').text(0);
            $('#email-count').text(arr.length);

            let realLabel = $('#radio-real-label');
            let phishingLabel = $('#radio-phishing-label');

            realLabel.removeClass('btn-success');
            realLabel.addClass('btn-outline-success');
            phishingLabel.removeClass('btn-danger');
            phishingLabel.addClass('btn-outline-danger');
        });
    });
});