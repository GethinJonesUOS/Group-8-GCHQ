let showGuideTipWeb1 = function() {
    let guideStep = $('#webbrowser-info');
    guideStep.tooltip({html: true,
        toggle: 'tooltip',
        placement: 'bottom',
        trigger: 'manual',
        sanitize: false,
    });
    guideStep.tooltip("show");
    $('#web-guide-2-next').click(function () {
        guideStep.tooltip("hide");
        showGuideTipWeb2();
    });
    activeGuideStep = 2;
}

let showGuideTipWeb2 = function() {
    let guideStep = $('#webbrowser-page');
    guideStep.tooltip({html: true,
        toggle: 'tooltip',
        placement: 'top',
        trigger: 'manual',
        sanitize: false,
    });
    guideStep.tooltip("show");
    $('#web-guide-3-next').click(function () {
        guideStep.tooltip("hide");
        showGuideTipWeb3();
    });
    activeGuideStep = 3;
}

let showGuideTipWeb3 = function() {
    let guideStep = $('#webbrowser-test');
    guideStep.tooltip({html: true,
        toggle: 'tooltip',
        placement: 'top',
        trigger: 'manual',
        sanitize: false,
    });
     guideStep.tooltip("show");
     $('#web-guide-4-next').click(function () {
         guideStep.tooltip("hide");
         activeGuideStep = 0;
     });
    activeGuideStep = 4;
}
showGuideTipWeb1();