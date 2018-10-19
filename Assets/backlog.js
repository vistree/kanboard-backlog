$(document).ready(function() {
   if ($('#kanboard-column th').hasClass( "board-column-header-collapsed" )) {
       $("#kanboard-column").css("width", "28px");
       $("#kanboard-column").css("min-width", "28px");
   }
});

Kanboard.BoardColumnView.prototype.listen = function (event) {
    var e = this;
    var backlog_column = $('#kanboard-column th').attr('data-column-id');
    var board_column_count = $('#kanboard-column').attr('data-nb_columns');
    var backlog_column_width = 100 / board_column_count;

    $(document).on("click", ".board-toggle-column-view", function (column) {
        e.toggle($(this).data("column-id"));
        if (column.target.dataset.columnId == backlog_column) {
            if (this.tagName == 'DIV') {
                $("#kanboard-column").css("width", backlog_column_width + "%");
                $("#kanboard-column").css("min-width", "240px");
            } else {
                $("#kanboard-column").css("width", "28px");
                $("#kanboard-column").css("min-width", "28px");
            }
        }
    })
};