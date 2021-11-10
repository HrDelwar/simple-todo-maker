(function ($) {
    $(document).ready(function () {

        window.wpstm_todos_global_register_event = function wpstm_todos_global_register_event() {
            $("input[id*='check_view_input-']").on('click', function () {
                const inputId = $(this)[0].id.split('-').reverse()[0];
                changeTodoStatus(inputId);
            });

            $("div[id*='todo_view_item-']").on('dblclick', function () {
                const inputId = $(this)[0].id.split('-').reverse()[0];
                changeTodoStatus(inputId);
            })

            $("button[id*='todo_view_delte_btn-']").on('click', function () {
                const inputId = $(this)[0].id.split('-').reverse()[0];
                deleteTodo(inputId);
            })

        }

        wpstm_todos_global_register_event();

        function changeTodoStatus(id) {
            $.ajax({
                url: ajax_object.ajaxurl,
                type: "POST",
                data: {
                    id: id,
                    action: 'wpstm_change_todo_status',
                    nonce: ajax_object.nonce
                },
                beforeSend() {
                },
                success(res) {
                    if (res.status) {
                        const element = $("#check_view_input-" + id);
                        if (res.completed) {
                            element.parent().addClass('active')
                            element.prop("checked", true)
                        } else {
                            element.parent().removeClass('active')
                            element.prop("checked", false)
                        }
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

            })
        }

        function deleteTodo(id) {

            Swal.fire({
                title: 'Info!',
                text: 'Sure you want to delete this?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Delete',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: ajax_object.ajaxurl,
                        type: 'POST',
                        data: {
                            id,
                            action: 'wpstm_delete_todo',
                            nonce: ajax_object.nonce
                        },
                        beforeSend() {
                        },
                        success(res) {
                            if (res.status) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: res.message,
                                    icon: 'success',
                                    position: 'center',
                                    confirmButton: false,
                                    timer: 1500
                                })
                                $('#todo_view_item-' + id).hide()

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
                    })
                }
            })
        }
    });
})(jQuery)



