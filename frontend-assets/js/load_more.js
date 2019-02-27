$(document).ready(function () {
    $("#load-comments").click(function () {
        $.ajax({
            url: '/comments/getmore',
            type: 'GET',
            data: 'trick=' + $("#load-comments").data('trick') + '&index=' + $("#load-comments").data('index'),
            datatype: 'json',
            success: function (comments, status) {
                $(comments).appendTo('#comments')
            },

            error: function (result, status, error) {

            },

            complete: function (result, statut) {

            }
        });
    });
});


