(function ($) {

    $(document).ready(function () {
        $(document).on('submit', '#add_todo_form', function (e) {
            e.preventDefault();
            let inputBtn = $('#add_todo_form input[name="todo_name"]');

            $.ajax({
                type: 'POST',
                url: ajax_object.ajaxurl,
                dataType: 'json',
                data: {
                    action: 'wpstm_create_todo',
                    todo_name: inputBtn.val(),
                    nonce: ajax_object.nonce
                },
                success(res) {
                    if (res.status) {
                        Swal.fire({
                            text: res.message,
                            icon: 'success',
                            toast: true,
                            timer: 2000,
                            position: 'bottom-end',
                            showConfirmButton: false,
                        })

                        //catch todos parent div
                        const todosParent = $('#todo_view_container');

                        //check todosParent is render in dom
                        if (Object.keys(todosParent).length > 0) {

                            // append new inside todos parent
                            todosParent.prepend(`
                            <div class='todo_item ' id='todo_view_item-${res.id}' title = 'Double click for change status.'>
                                <input type = 'checkbox' id = 'check_view_input-${res.id}' >
                                <h4 class='todo_title no_select' >
                                    ${inputBtn.val()}
                                </h4 >
                                <button class='todo_delete_btn' id='todo_view_delte_btn-${res.id}'>
                                   <i class='far fa-trash-alt'></i>
                                 </button >
                             </div >
                            `);

                            // clear todos not found message
                            const not_fount = $('#todo_not_found_p');
                            if (Object.keys(not_fount).length > 0) {
                                not_fount.hide();
                            }

                            // re register event in todos view
                            wpstm_todos_global_register_event()
                        }

                        // clear input  value
                        inputBtn.val('');
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: res.message,
                            icon: 'error'
                        })
                    }
                },
                error(req, _, err) {
                    Swal.fire({
                        title: 'Error!',
                        text: err,
                        icon: 'error'
                    })
                }
            });

        });
    });

})(jQuery);
