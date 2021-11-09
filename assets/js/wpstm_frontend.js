(function ($) {

    $(document).on('submit', '#add_todo_form', function (e) {
        e.preventDefault();
        const inputval = $('#add_todo_form input[name="todo_name"]').val();

        $.ajax({
            type: 'POST',
            url: ajax_object.ajaxurl,
            dataType: 'json',
            data: {
                action: 'wpstm_create_todo',
                todo_name: inputval,
                nonce: ajax_object.nonce
            }
        })

    })

})(jQuery)