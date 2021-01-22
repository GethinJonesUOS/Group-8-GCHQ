let activeDragFile;
let nextWindowId = 0;
let activeWindowCount = 0;
let disableHints = false;
let openFiles = [];

let ratOpened = false;
let ransomwareOpened = false;
let adwareOpened = false;

let ratDeleted = false;
let ransomwareDeleted = false;
let adwareDeleted = false;
let confidentialDeleted = 0;

let desktop = $('#desktop');

desktop.append('<div id="form-controls" style="position: absolute; top: 0; z-index: 20"><button id="submit" class="btn btn-info mx-3">Submit</button><button id="reset-files" class="btn btn-info mx-3">Reset Files</button></div>');
let formControls = $('#form-controls');
let formControlCentre = formControls.css('width').match(/[0-9]{1,5}/) / 2;
let desktopCentre = desktop.css('width').match(/[0-9]{1,5}/) / 2;
formControls.css({'left': desktopCentre - formControlCentre + 'px'});

$('#submit').click(function() {
    let modalWindow = $('#scores-modal');
    let scoresList = modalWindow.find('#scores-list');

    modalWindow.css({'z-index': 10000});
    let myModal = new bootstrap.Modal(modalWindow[0], {backdrop: 'static', keyboard: false, focus: true});

    scoresList.html('');
    let score = 0;

    if (!ratOpened) {
        scoresList.append('<li>+10 - The wages.xlsx file contained a macro that would have located your personal information and transmitted it to an unknown party. Well done for not opening it.</li>');
        score += 10;
    } else {
        scoresList.append('<li>+0 - Oh dear! You opened the wages.xlsx file. Unfortunately it contained a macro that  located your personal information and transmitted it to an unknown party.</li>');
    }

    if (!adwareOpened) {
        scoresList.append('<li>+10 - The hot.jpg.exe file may have looked like it would open image but was in fact an executable that would have installed intrusive adWare. Well done for not opening it.</li>');
        score += 10;
    } else {
        scoresList.append('<li>+0 - Guess the temptation to see that &apos;image&apos; file was too great. Sadly it wasn&apos;t an image at all and was actually an executabe that is now flooding your screen with spam.</li>');
    }

    if (!ransomwareOpened) {
        scoresList.append('<li>+10 - The schedule.pif file contained ransomware that would have encrypted your files. Well done for not opening it.</li>');
        score += 10;
    } else {
        scoresList.append('<li>+0 - Whoops! It seems you managed to initiate some ransomware which has encrypted all of your personal files.</li>');
    }

    if (!ratOpened && ratDeleted) {
        scoresList.append('<li>+10 - The wages.xlsx file contained a macro that would have located your personal information and transmitted it to an unknown party. Well done for deleting it.</li>');
        score += 10;
    }
    if (!ransomwareOpened && ransomwareDeleted) {
        scoresList.append('<li>+10 - The schedule.pif file contained ransomware that would have encrypted your files. Well done for deleting it.</li>');
        score += 10;
    }
    if (!adwareOpened && adwareDeleted) {
        scoresList.append('<li>+10 - The hot.jpg.exe file may have looked like it would open image but was infact an executable that would have installed intrusive adWare. Well done for deleting it.</li>');
        score += 10;
    }

    if (confidentialDeleted === 1) {
        scoresList.append('<li>+10 - You deleted one of the unprotected files containing personal information but, there&apos;s still one more you didn&apos;t get.</li>');
        score += 10;
    } else if (confidentialDeleted === 2) {
        scoresList.append('<li>+20 - You deleted both of the unprotected files containing personal information. Well done!</li>');
        score += 20;
    }

    $('#final-score').html(score + '/' + 80)
    $('#form-score').val(Math.round(score / 80 * 100).toString());

    myModal.show();
});

$('#try-again').click(function() {
    window.location.href = "/files.php";
});

$('#reset-files').click(function() {
    window.location.href = "/files.php";
});

let buildWindow = function(options) {
    if (openFiles.includes(options.title)) {
        makeFront($('[sourcefile="' + options.title + '"]'));
        return null;
    }

    let width = '350px';
    if (options.hasOwnProperty('width')) {
        width = options.width;
    }

    let height = '275px';
    if (options.hasOwnProperty('height')) {
        height = options.height;
    }

    let top = '20px';
    if (options.hasOwnProperty('top')) {
        top = options.top;
    }

    let left = '20px';
    if (options.hasOwnProperty('left')) {
        left = options.left;
    }

    let onClose = null;
    if (options.hasOwnProperty('onClose')) {
        onClose = options.onClose;
    }

    let bgColor = 'rgb(255, 255, 255)';
    if (options.hasOwnProperty('bgColor')) {
        bgColor = options.bgColor;
    }

    let windowTitleIdStr = 'window-title-' + options.id;
    $('#desktop').append('' +
        '<div class="container rounded shadow border border-dark window p-0" ' +
        'style="box-sizing: content-box; background-color: ' + bgColor + '; width: ' + width + '; height: ' + height + '; position: absolute; top: ' + top + '; left: ' + left + '" sourcefile="' + options.title + '">' +
        '<div name="window-title" id="' + windowTitleIdStr + '" class="col-12 px-2 py-1 bg-dark text-light text-truncate"><img src="images/close-window.png" name="close" id="window-close-' + options.id + '" class="float-right py-1" window-id="' + options.id + '"></div>' +
        '<div class="p-0 m-0" name="pane"></div></div>');

    let window = $('[sourcefile="' + options.title + '"]');
    let title = window.find('[name="window-title"]');
    let pane = window.find('[name="pane"]');

    title.html('<span>' + options.title + '</span>');

    title.append('<img src="images/close-window.png" name="close" id="window-close-' + options.id + '" class="float-right py-1" window-id="' + options.id + '">');
    let close = window.find('[name="close"]');
    close.click(function() {
        closeWindow(window, onClose);
    });

    if (options.hasOwnProperty('addContent')) {
        options.addContent(pane, options.title);
    }

    window.draggable({
        containment: '#desktop',
        handle: '[name="window-title"]'
    });

    window.mousedown(function() {
        makeFront(window);
    });

    nextWindowId++;
    activeWindowCount++;
    openFiles.push(options.title);

    return window;
}

let makeFront = function(window) {
    window.siblings().css('zIndex', 0);
    window.css('zIndex', 100);
}

let closeWindow = function(window, callback = null) {
    if (callback !== null) {
        callback(window);
    }
    const index = openFiles.indexOf(window.attr('sourcefile'));
    if (index > -1) {
        openFiles.splice(index, 1);
    }
    window.remove();
    activeWindowCount--;
}

let openFile = function(fileName) {
    let top = (activeWindowCount * 35).toString() + 'px';

    let window = buildWindow({
        title: fileName,
        id: nextWindowId,
        left: '600px',
        top: top,
        addContent: function(pane, filename) {
            pane.load('files.php?action=filecontent&filename=' + fileName, function() {

            });
        },
        onClose: function(window) {
            if ($('#tutorial-2').length != 0) {
                window.tooltip('hide');
                showStep3();
            }
        }
    });

    return window;
}

let openRansomWare = function() {
    let window = buildWindow({
        title: 'CryptoTron',
        id: nextWindowId,
        left: '300px',
        top: '30px',
        bgColor: 'red',
        width: '720px',
        height: '500px',
        addContent: function(pane, filename) {
            pane.load('cryptotron.html', function() {

            });
        },
        onClose: function(window) {

        }
    });

    makeFront(window);
    return window;
}

let openFileThief = function() {
    let window = buildWindow({
        title: 'File Thief',
        id: nextWindowId,
        left: '300px',
        top: '220px',
        height: '150px',
        addContent: function(pane, filename) {
            pane.html('<p class="text-center">Locating Files</p>');
            setTimeout(function() {
                pane.html('<p class="text-center">Connecting to server</p>');
            }, 2000);
            setTimeout(function() {
                pane.html('<p class="text-center">Transmitting Confidential Files</p>');
            }, 4000);
            setTimeout(function() {
                pane.html('<p class="text-center">Draining money from your accounts</p>');
            }, 6000);
        }
    });
    makeFront(window);
    return window;
}

let startSpam = function() {
    let desktop = $('#desktop');
    let desktopWidth = desktop.css('width').match(/[0-9]{1,5}/);
    let desktopHeight = desktop.css('height').match(/[0-9]{1,5}/);
    let windowWidth = 330;
    let windowHeight = 140;

    let messages = [
        'Save $$$ on great deals',
        'XXX Hot girls in your area',
        'Click here for MEGA SALES',
        'CONGRATULATIONS! You&apos;ve won a new iPhone 12',
        'WARNING! VIRUS DETECTED! Call now for instant removal'
    ];

    let delay = 5000;


    let window = buildWindow({
        title: 'Spam-' + Math.floor(Math.random() * 1000000),
        id: nextWindowId,
        left: Math.floor(Math.random() * (desktopWidth - windowWidth)) + 'px',
        top: Math.floor(Math.random() * (desktopHeight - windowHeight)) + 'px',
        width: windowWidth + 'px',
        height: windowHeight + 'px',
        bgColor: 'rgb(' + randomColorChannel() + ', ' + randomColorChannel() + ', ' + randomColorChannel() + ')',
        addContent: function (pane, filename) {
            pane.html('<h3 class="text-center">' + messages[Math.floor(Math.random() * messages.length)] + '</h3>');
        }
    });
    makeFront(window);

    setTimeout(function() {
        startSpam();
    }, delay);
}

let randomColorChannel = function() {
    return Math.floor(Math.random() * 256);
}

$("#waste-bin").droppable({
    drop: function(event, ui) {
        let action = ui.draggable.attr('action');
        switch (action) {
            case "2":
                ratDeleted = true;
                break;
            case "3":
                ransomwareDeleted = true;
                break;
            case "4":
                adwareDeleted = true;
                break;
            case "5":
                confidentialDeleted++;
                break;
        }
        activeDragFile.remove();
    }
});

let showStep3 = function() {
    let wasteBin = $('#waste-bin');
    wasteBin.tooltip({trigger: 'manual', boundary: '#desktop', html: true, placement: 'right', sanitize: false, title: '<h3>Step 3</h3><p>Any files that you think are potentially dangerous to have on your computer can be deleted by dragging the icon to the the Waste Bin.</p><button class="btn btn-info" name="tutorial-3">Next</button><button class="btn btn-link text-reset" name="tutorial-3" skip>skip tutorial</button>'});
    wasteBin.tooltip('show');
    $('[name="tutorial-3"]').click(function() {
        wasteBin.tooltip('hide');
        if ($(this).attr('skip') === undefined) {
            showStep4();
        }
    });
}

let showStep4 = function() {
    let submit = $('#submit');
    submit.tooltip({trigger: 'manual', boundary: '#desktop', html: true, placement: 'bottom', sanitize: false, title: '<h3>Step 4</h3><p>Once you have deleted all the files that you think should be deleted, press submit to see how you did.</p><button class="btn btn-info" id="tutorial-4">Close</button>'});
    submit.tooltip('show');
    $('#tutorial-4').click(function() {
        submit.tooltip('hide');
    });
}

buildWindow({
    title: 'Files',
    id: nextWindowId,
    width: '400px',
    height: '350px',
    top: '50px',
    left: '150px',
    addContent: function(pane, filename) {
        $.post('files.php', {action: 'getfiles'}).done(function (data) {
            pane.append('<div class="row row-cols-4 mt-3 px-2 file-grid"></div>');
            let fileGrid = pane.find('.file-grid');
            for (i in data.files) {
                let file = data.files[i];
                let fileName = file.fileName;
                let icon = file.icon;
                let action = file.action;

                let colID = nextWindowId + '-' + i;
                fileGrid.append('<div class="col" action="' + action + '" file="' + fileName + '" id="' + colID + '" title="' + data.tooltips[i] + '"></div>');
                fileGrid.tooltip({trigger: 'manual', boundary: '#desktop', html: true, placement: 'left', sanitize: false, title: '<h3>Step 1</h3><p>Hover the cursor over any of the files to get hints about how to identify potentially unwanted programs.</p><button class="btn btn-info" name="tutorial-1">Next</button><button class="btn btn-link text-reset" name="tutorial-1" skip>skip tutorial</button>'});
                fileGrid.tooltip("show");

                let col = fileGrid.find('#' + colID + '');
                col.html('<div class="card border-0 bg-transparent" style="width: 70px"></div>');

                let card = col.find('.card');
                card.html('<img class="card-img-top" src="images/' + icon + '" alt="email icon"><p class="text-center text-reset">File4.txt</p>');

                let fileNameField = card.find('p');
                fileNameField.html(fileName);

                col.draggable({
                    start: function() {
                        activeDragFile = $(this);
                    },
                    containment: '#desktop',
                    revert: "invalid",
                    stop: function() {
                        disableHints = false;
                    },
                    drag: function() {
                        disableHints = true;
                        col.tooltip("hide");
                    }
                });

                col.tooltip({trigger: 'manual', boundary: '#desktop', html: true, placement: 'right'});

                col.mouseover(function () {
                    col.tooltip("show");
                });

                col.mouseout(function() {
                    col.tooltip("hide");
                });

                if (action == 1 || action == 5) {
                    col.dblclick(function () {
                        openFile(fileName);
                    });
                } else if (action == 2) {
                    col.dblclick(function () {
                        ratOpened = true;
                        openFile(fileName);
                        setTimeout(function() {
                            openFileThief();
                        }, 2000);
                    });
                } else if (action == 3) {
                    col.dblclick(function () {
                        ransomwareOpened = true;
                        openRansomWare();
                    });
                } else if (action == 4) {
                    col.dblclick(function () {
                        setTimeout(function() {
                            adwareOpened = true;
                            startSpam();
                        }, 2500);
                    });
                }

                $('[name="tutorial-1"]').click(function() {
                    fileGrid.tooltip("hide");

                    if ($(this).attr('skip') === undefined) {
                        let window = openFile(data.files[0].fileName);
                        window.tooltip({
                            trigger: 'manual',
                            boundary: '#desktop',
                            html: true,
                            placement: 'left',
                            sanitize: false,
                            title: '<h3>Step 2</h3><p>If you think the file is safe to open, you can double click on the icon to view what&apos;s inside.</p><button class="btn btn-info" name="tutorial-2">Next</button><button class="btn btn-link text-reset" name="tutorial-2" skip>skip tutorial</button>'
                        });
                        window.tooltip("show");
                        $('[name="tutorial-2"]').click(function () {
                            window.tooltip('hide');
                            if ($(this).attr('skip') === undefined) {
                                showStep3();
                            }
                        });
                    }
                });
            }
        });
    }
});