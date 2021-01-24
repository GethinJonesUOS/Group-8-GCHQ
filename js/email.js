let activeEmailID = -1;
let activeGuideStep = 0;
let skipTutorial = false;

/**
 * Selects all elements flagged for showing hints and applies hint tooltip settings.
 *
 * Must be called everytime a new email is loaded.
 */
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

/**
 * Show tutorial step 1 tooltip.
 */
let showGuideTip1 = function() {
    let guideStep1 = $('[guide-step="1"]');
    guideStep1.tooltip({html: true,
        toggle: 'tooltip',
        placement: 'right',
        boundary: '#email-client',
        trigger: 'manual',
        sanitize: false,
    });
    guideStep1.tooltip("show");
    $('[name="tutorial-1"]').click(function () {
        guideStep1.tooltip("hide");
        skipTutorial = true;
    });
    activeGuideStep = 1;
}

/**
 * Show tutorial step 2 tooltip.
 */
let showGuideTip2 = function() {
    if (!skipTutorial) {
        let guideStep = $('#email-content');
        guideStep.tooltip({
            "html": true,
            "toggle": 'tooltip',
            "placement": 'left',
            "trigger": 'manual',
            "sanitize": false
        });
        guideStep.tooltip("show");
        $('[name="tutorial-2"]').click(function () {
            guideStep.tooltip("hide");
            if ($(this).attr('skip') !== undefined) {
                skipTutorial = true;
            }
            showGuideTip3();
        });
    }
    activeGuideStep = 2;
}

/**
 * Show tutorial step 3 tooltip.
 */
let showGuideTip3 = function() {
    if (!skipTutorial) {
        let guideStep = $('#answer-form');
        guideStep.tooltip({
            "html": true,
            "toggle": 'tooltip',
            "placement": 'top',
            "trigger": 'manual',
            "sanitize": false
        });
        guideStep.tooltip("show");
        $('[name="tutorial-3"]').click(function () {
            guideStep.tooltip("hide");
            if ($(this).attr('skip') !== undefined) {
                skipTutorial = true;
            }
            showGuideTip4();
        });
    }
    activeGuideStep = 3;
}

/**
 * Show tutorial step 4 tooltip.
 */
let showGuideTip4 = function() {
    if (!skipTutorial) {
        let guideStep = $('#answer-submit');
        guideStep.tooltip({
            "html": true,
            "toggle": 'tooltip',
            "placement": 'bottom',
            "trigger": 'manual',
            "sanitize": false
        });
        guideStep.tooltip("show");
        $('#guide-4-next').click(function () {
            guideStep.tooltip("hide");
            activeGuideStep = 0;
        });
    }
    activeGuideStep = 4;
}

/**
 * Get the answers previously supplied by the user from the session
 * and colour code the card headers.
 */
let loadSessionAnswers = function() {
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
}

/**
 * Callback function for email card click event.
 */
let emailCardOnClick = function() {
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
}

/**
 * Call back function when answer is selected.
 */
let answerRadioBtnOnClick = function() {
    let guideStep = $('#answer-form');
    if (activeGuideStep == 3) {
        guideStep.tooltip("hide");
        showGuideTip4();
    }

    $('#answer-form').submit();
}

/**
 * Callback function for when the answer form is submitted for an individual email.
 *
 * @param event Object containing data that will be passed to the event handler
 */
let answerFormSubmit = function(event) {
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
}

/**
 * Callback function for the reset emails button
 */
let resetCallback = function() {
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
}

/**
 * Runs when page finishes loading.
 */
$(document).ready(function() {
    setupTooltips();
    showGuideTip1();
    loadSessionAnswers();

    $('.email-card').click(emailCardOnClick);
    $('input[name=answer]:radio').click(answerRadioBtnOnClick);
    $('#answer-form').submit(answerFormSubmit);
    $('#answer-reset').click(resetCallback);
});