let activeEmailID = -1;
let activeGuideStep = 0;

let setupTooltips = function () {
    [].slice.call(document.querySelectorAll('[hint]')).map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl,
            { html: true,
                    toggle: 'tooltip',
                    placement: 'auto',
                    boundary: '#email-client'
                   });
    });

    let urlHints = $('[url]');
    urlHints.mouseover(function () {
        $('#status').html(($(this).attr('url')));
    });

    urlHints.mouseout(function () {
        $('#status').html('&nbsp;');
    });
}

let showGuideTip2 = function() {
    let guideStep = $('#email-content');
    guideStep.tooltip({html: true,
        toggle: 'tooltip',
        placement: 'left',
        trigger: 'manual',
        sanitize: false,
    });
    guideStep.tooltip("show");
    $('#guide-2-next').click(function () {
        guideStep.tooltip("hide");
        showGuideTip3();
    });
    activeGuideStep = 2;
}

let showGuideTip3 = function() {
    let guideStep = $('#answer-form');
    guideStep.tooltip({html: true,
        toggle: 'tooltip',
        placement: 'top',
        trigger: 'manual',
        sanitize: false,
    });
    guideStep.tooltip("show");
    $('#guide-3-next').click(function () {
        guideStep.tooltip("hide");
        showGuideTip4();
    });
    activeGuideStep = 3;
}

let showGuideTip4 = function() {
    let guideStep = $('#answer-submit');
    guideStep.tooltip({html: true,
        toggle: 'tooltip',
        placement: 'bottom',
        trigger: 'manual',
        sanitize: false,
    });
    guideStep.tooltip("show");
    $('#guide-4-next').click(function () {
        guideStep.tooltip("hide");
        activeGuideStep = 0;
    });
    activeGuideStep = 4;
}

$(document).ready(function() {
    setupTooltips();

    let guideStep1 = $('[guide-step="1"]');
    guideStep1.tooltip({html: true,
        toggle: 'tooltip',
        placement: 'right',
        boundary: '#email-client',
        trigger: 'manual',
        sanitize: false,
    });
    guideStep1.tooltip("show");
    $('#guide-1-next').click(function () {
        guideStep1.tooltip("hide");
        showGuideTip2();
    });
    activeGuideStep = 1;



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
        let guideStep1 = $('[guide-step="1"]');
        if (activeGuideStep == 1) {
            guideStep1.tooltip("hide");
            showGuideTip2();
        }

        let newEmailID = $(this).attr('email-id');

        $('#email-body').load('email.php?emailbody='.concat(newEmailID),
            function() {
                setupTooltips();
            });

        $.post('email.php', {action: 'getheader', id: newEmailID}).done(function (data) {
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
        let guideStep = $('#answer-form');
        if (activeGuideStep == 3) {
            guideStep.tooltip("hide");
            showGuideTip4();
        }

        $('#answer-form').submit();
    });

    $('#answer-form').submit(function(event) {
        event.preventDefault();
        let selectedNode = $('input[name=answer]:radio:checked');
        let selectedAnswer = selectedNode.val();
        $.post('email.php', {action: 'answeremail', id: activeEmailID, answer: selectedAnswer}).done(function (data) {
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
                let answerSubmit = $('#answer-submit');
                answerSubmit.prop('disabled', false);
                answerSubmit.removeClass('btn-secondary');
                answerSubmit.addClass('btn-success');
            }
            $('#answer-count').text(data.answerCount);
            $('#email-count').text(data.emailCount);
        });
    });

    $('#answer-reset').click(function() {
        $.post('email.php', {action: 'reset'}).done(function (data) {
            let arr = $('.email-card').find('.card-header');
            $.map(arr, function (n, i) {
                $(n).removeClass('bg-danger');
                $(n).removeClass('bg-success');
            });

            let answerSubmit = $('#answer-submit');
            answerSubmit.prop('disabled', true);
            answerSubmit.removeClass('btn-success');
            answerSubmit.addClass('btn-secondary');
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