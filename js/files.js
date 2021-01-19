let activeDragFile;
let nextWindowId = 0;
let activeWindowCount = 0;
let disableHints = false;

let buildWindow = function(options) {
    let width = '350px';
    if (options.hasOwnProperty('width')) {
        width = options.width;
    }

    let height = '300px';
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

    let windowTitleIdStr = 'window-title-' + options.id;
    $('#desktop').append('' +
        '<div class="container bg-white rounded shadow window" ' +
        'style="width: ' + width + '; height: ' + height + '; position: absolute; top: ' + top + '; left: ' + left + '" sourcefile="' + options.title + '">' +
        '<div name="window-title-bar" class="row"><div name="window-title" id="' + windowTitleIdStr + '" class="col-10 px-2 py-1 bg-dark text-light text-truncate"></div><div class="col-2 bg-dark text-light"><span name="close" id="window-close-' + options.id + '" class="float-right py-1" window-id="' + options.id + '"><img src="images/close-window.png"></span></div></div>' +
        '<div name="pane"></div></div>');

    let window = $('[sourcefile="' + options.title + '"]');
    let title = window.find('[name="window-title"]');
    let pane = window.find('[name="pane"]');
    let close = window.find('[name="close"]');

    title.text(options.title);
    close.click(closeWindow);

    if (options.hasOwnProperty('addContent')) {
        options.addContent(pane, options.title);
    }

    window.draggable({
        containment: '#desktop',
        handle: '[name="window-title-bar"]'
    });

    window.mousedown(function() {
        window.siblings().css('zIndex', 0);
        window.css('zIndex', 100);
    });

    nextWindowId++;
    activeWindowCount++;
}

let closeWindow = function() {
    $(this).parents('.window').remove();
}

$("#waste-bin").droppable({
    drop: function() {
        activeDragFile.remove();
    }
});

buildWindow({
    title: 'Files',
    id: nextWindowId,
    width: '400px',
    height: '400px',
    top: '30px',
    left: '150px',
    addContent: function(pane, filename) {
        $.post('files.php', {action: 'getfiles'}).done(function (data) {
            pane.append('<div class="row row-cols-4 mt-3 file-grid"></div>');
            let fileGrid = pane.find('.file-grid');
            for (i in data.files) {
                let fileName = data.files[i].fileName;
                let colID = nextWindowId + '-' + i;
                fileGrid.append('<div class="col" file="' + fileName + '" id="' + colID + '" title="' + data.tooltips[i] + '"></div>');

                let col = fileGrid.find('#' + colID + '');
                col.html('<div class="card border-0 bg-white" style="width: 70px"></div>');

                let card = col.find('.card');
                card.html('<img class="card-img-top" src="images/file.png" alt="email icon"><p class="text-center text-reset">File4.txt</p>');

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

                col.dblclick(function() {
                    buildWindow({
                        title: fileName,
                        id: nextWindowId,
                        left: '600px',
                        addContent: function(pane, filename) {
                            pane.load('files.php?action=filecontent&filename=' + fileName, function() {

                            });
                        }
                    });
                });
            }
        });
    }
});