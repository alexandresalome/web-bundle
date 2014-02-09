$(function() {
    $(document).on('click', 'a[data-confirm]', function (event) {
        event.preventDefault();
        var $code = $('<div class="modal fade">' +
            '<div class="modal-dialog">' +
                '<div class="modal-content">' +
                    '<div class="modal-body">' +
                        '<h4></h4>' +
                    '</div>' +
                    '<div class="modal-footer">' +
                        '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
                        '<button type="button" class="btn btn-primary" data-confirm="confirm">Confirm</button>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>');

        var $current = $(event.currentTarget);

        $code.find('h4').text($current.attr('data-confirm'))
        $code.find('button[data-confirm]').click(function () {
            document.location = $current.attr('href');
        });
        $code.modal();
    });
});
