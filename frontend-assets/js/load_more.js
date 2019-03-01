$(document).ready(function () {
    $("#load-comments").click(function () {
        var loadCommentsButton = $("#load-comments");
        var oldPaginationIndex = loadCommentsButton.data('page');
        var paginationPath = loadCommentsButton.data('pagination-path');
        var totalPages = loadCommentsButton.data('total-pages')
        var newPaginationIndex = oldPaginationIndex + 1;

        loadCommentsButton.data('page', newPaginationIndex);
        $.ajax({
            url: paginationPath + '?page=' + loadCommentsButton.data('page'),
            type: 'GET',
            datatype: 'html',
            success: function (comments, status) {
                if(totalPages <=  newPaginationIndex) {
                    $(comments).appendTo('#comments');
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


