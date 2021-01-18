let activeDragFile;
$('#files-window').draggable({
    containment: '#desktop',
    handle: '#window-title'
});
$('[file]').draggable({
    start: function() {
        activeDragFile = $(this);
    },
    containment: '#desktop',
    revert: "invalid"
});
$("#waste-bin").droppable({
    drop: function() {
        activeDragFile.remove();
    }
});