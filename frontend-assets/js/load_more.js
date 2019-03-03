$(document).ready(function () {
    $("#load-comments").click(function () {
        var loadCommentsButton = $("#load-comments");
        var oldPaginationIndex = loadCommentsButton.data('page');
        var paginationPath = loadCommentsButton.data('pagination-path');
        var totalPages = loadCommentsButton.data('total-pages')
        var newPaginationIndex = oldPaginationIndex + 1;

        loadCommentsButton.data('page', newPaginationIndex);
        $.ajax({
            url: paginationPath + '?page=' + newPaginationIndex,
            type: 'GET',
            datatype: 'html',
            success: function (comments, status) {
                $(comments).appendTo('#comments');
                if(totalPages <=  newPaginationIndex) {
                    loadCommentsButton.prop("hidden", true);
                }
            },

            error: function (result, status, error) {
                console.log(status);
            },

            complete: function (result, statut) {

            }
        });
    });
});


